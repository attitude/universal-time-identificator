// WIP example of JS implementation adding nanoseconds entropy

const BITS = 6;
const ALPHABET = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
const PADING = '0';

function splitString(text, length) {
  length = length === 0 ? 0 : length ? Math.max(0, length) : 1

  const splitRegex = new RegExp(`.{${length}}`, 'g');
  const pieces = text.match(splitRegex);
  const last = pieces.length * length

  if (last < text.length) {
    pieces.push(text.substring(last))
  }

  return pieces
}

function padBits(bits, length) {
  length = Math.ceil((length ? length : bits.length) / BITS) * BITS;

  return bits.padStart(length, PADING);
}

function bindec(bits) {
  return parseInt(bits, 2);
}

function decbin(dec) {
  return parseInt(dec, 10).toString(2);
}

function alpha(bits) {
  return ALPHABET[bindec(bits)];
}

function bits(char) {
  return padBits(
      decbin(ALPHABET.indexOf(char))
  );
}

let lastMilisecond;
let counter = Math.random() * 500;

////// PUBLIC API //////

export function nanosecods() {
  const nextMilisecond = Date.now();
  lastMilisecond = lastMilisecond ? lastMilisecond : Date.now();

  counter = nextMilisecond > lastMilisecond ? Math.random() * 900 : counter;
  counter++;

  lastMilisecond = nextMilisecond;

  return Math.round(nextMilisecond * 1000 + counter);
}

export function encode (number) {
  return splitString(
    padBits(decbin(number)),
    BITS
  ).map(alpha).join('');
}

export function decode (text) {
  return bindec(
    splitString(text).map(bits).join('')
  );
}

export function get () {
  return encode(nanosecods());
}
