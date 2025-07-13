function dec2hex(s) {
            return (s < 15.5 ? "0" : "") + Math.round(s).toString(16);
        }

        function hex2dec(s) {
            return parseInt(s, 16);
        }

        function base32tohex(base32) {
            var base32chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
            var bits = "";
            var hex = "";

            for (var i = 0; i < base32.length; i++) {
                var val = base32chars.indexOf(base32.charAt(i).toUpperCase());
                bits += lpad(val.toString(2), 5, "0");
            }

            for (i = 0; i + 4 <= bits.length; i += 4) {
                var chunk = bits.substr(i, 4);
                hex = hex + parseInt(chunk, 2).toString(16);
            }
            return hex;
        }

        function lpad(str, len, pad) {
            if (len + 1 >= str.length) {
                str = new Array(len + 1 - str.length).join(pad) + str;
            }
            return str;
        }

        function getOTP(secret, epoch) {
            var key = base32tohex(secret);
            var time = lpad(dec2hex(Math.floor(epoch / 30)), 16, "0");

            var shaObj = new jsSHA("SHA-1", "HEX");
            shaObj.setHMACKey(key, "HEX");
            shaObj.update(time);
            var hmac = shaObj.getHMAC("HEX");

            var offset = hex2dec(hmac.substring(hmac.length - 1));
            var otp = (hex2dec(hmac.substr(offset * 2, 8)) & hex2dec("7fffffff")) + "";
            return otp.substr(otp.length - 6, 6);
        }

        var secret = "<?php echo $secret; ?>";

        function validateOTP() {
            var epoch = Math.round(new Date().getTime() / 1000.0);
            var otp = getOTP(secret, epoch);
            var userOTP = document.getElementById('code').value;

            if (userOTP === otp) {
                // OTP is correct, set the session variables using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "set_2fa_valid.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        window.location.href = 'index.php';
                    }
                };
                xhr.send("2fa_valid=true");
                return false; // Prevent form submission
            } else {
                // OTP is incorrect, display an error message
                alert("Invalid 2FA code.");
                return false; // Prevent form submission
            }
        }