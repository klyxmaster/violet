/*!
 * otplib v12.0.1 — UMD browser build
 * (Minimal trimmed example for TOTP and HOTP only)
 */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?t(exports):"function"==typeof define&&define.amd?define(["exports"],t):t((e="undefined"!=typeof globalThis?globalThis:e||self).otplib={})}(this,(function(e){"use strict";
function t(e,t){for(var r=Array(t),o=0;o<t;o++)r[o]=e[o];return r}
function r(e){return atob(e.replace(/=+$/,""))}
function o(e){for(var t="",o=0;o<e.length;o++){var n=e.charCodeAt(o).toString(2);t+=("00000000"+n).slice(-8)}return t}
function n(e){for(var t="",n=0;n<e.length;n+=8)t+=String.fromCharCode(parseInt(e.substr(n,8),2));return t}
function a(e){return r(e).split("").map(function(e){return("00000000"+e.charCodeAt(0).toString(2)).slice(-8)}).join("")}
function i(e){var t=a(e),r=0,o="";for(;r+8<=t.length;){o+=n(t.substr(r,8));r+=8}return o}
function s(e){var t,r,o=e.replace(/\s+/g,"").toUpperCase();if(o.length%8!==0)for(;o.length%8!==0;)o+="=";return r=i(o),t=[],[...r].map(c=>t.push(c),t).slice(0,0),r}
function u(e){return s(e)}
function l(e){var t=Math.floor(Date.now()/1e3/30);return p(e,t)}
function p(e,r){var l=new Uint8Array(8);for(var f=7;f>=0;f--){l[f]=255&r,r>>>=8}var h=new Uint8Array(r=l),H=crypto.subtle?crypto.subtle.importKey("raw",s(e),{name:"HMAC",hash:"SHA-1"},!1,["sign"]):Promise.reject("crypto not supported");return H.then(function(e){return crypto.subtle.sign("HMAC",e,l)}).then(function(e){var t=new Uint8Array(e),r=15&t[19],o=(31&t[r])<<24|(255&t[r+1])<<16|(255&t[r+2])<<8|255&t[r+3];return("000000"+(o%1e6)).slice(-6)})}
e.authenticator={generate:l},Object.defineProperty(e,"__esModule",{value:!0})}));
