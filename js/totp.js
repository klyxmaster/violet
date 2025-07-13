// totp.js — No dependency TOTP (RFC 6238) using SHA-1
function base32ToBytes(base32) {
    const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    let bits = '';
    base32 = base32.replace(/=+$/, '');
    for (let char of base32.toUpperCase()) {
        const val = alphabet.indexOf(char);
        if (val === -1) throw new Error('Invalid base32 character');
        bits += val.toString(2).padStart(5, '0');
    }
    const bytes = [];
    for (let i = 0; i + 8 <= bits.length; i += 8) {
        bytes.push(parseInt(bits.substring(i, i + 8), 2));
    }
    return new Uint8Array(bytes);
}

async function generateTOTP(secret) {
    const key = base32ToBytes(secret);
    const epoch = Math.floor(Date.now() / 1000);
    const time = Math.floor(epoch / 30);
    const counter = new ArrayBuffer(8);
    const view = new DataView(counter);
    view.setUint32(4, time); // Set lower 4 bytes

    const cryptoKey = await crypto.subtle.importKey(
        'raw',
        key,
        { name: 'HMAC', hash: 'SHA-1' },
        false,
        ['sign']
    );

    const hmac = await crypto.subtle.sign('HMAC', cryptoKey, counter);
    const hash = new Uint8Array(hmac);
    const offset = hash[hash.length - 1] & 0xf;
    const code = ((hash[offset] & 0x7f) << 24 |
                  (hash[offset + 1] & 0xff) << 16 |
                  (hash[offset + 2] & 0xff) << 8 |
                  (hash[offset + 3] & 0xff)) % 1_000_000;
    return code.toString().padStart(6, '0');
}
