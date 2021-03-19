<?php

namespace UniversalTime\Identificator;

class UTID {
    /**
     * Length of the generated ID
     */
    const LENGTH = 9;

    /**
     * Alphabet of 64 chars in the ID, ascending in ASCII order
     */
    const ALPHABET = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';

    /**
     * Bits required to encode alphabet
     */
    private const RADIX = 6;

    /**
     * Nanoseconds in a second
     */
    public const PRECISION = 1000000;

    /**
     * String to use to left pad binary string
     */
    private const PADING = '0';

    public static function type(): string {
        return sprintf("CHAR(%d)", self::LENGTH);
    }

    /**
     * Coverts bits to character
     *
     * @param string $bits
     * @return string
     */
    private static function char(string $bits): string {
        return self::ALPHABET[bindec($bits)];
    }

    /**
     * Converts character to bits
     *
     * @param string $char
     * @return void
     */
    private static function bits(string $char) {
        return self::padBits(
            decbin(strpos(self::ALPHABET, $char))
        );
    }

    /**
     * Pads string of bits with zeros
     *
     * @param string $bits
     * @param int $length
     * @return void
     */
    private static function padBits(string $bits, int $length = null) {
        $length = ceil(($length ?? strlen($bits)) / self::RADIX) * self::RADIX;

        return str_pad($bits, $length, self::PADING, STR_PAD_LEFT);
    }

    /**
     * Retrieves time in nanoseconds
     *
     * @return int
     */
    public static function nanoseconds(): int {
        return (int) (microtime(true) * self::PRECISION);
    }

    /**
     * Converts int number to string
     *
     * @param int $nanoseconds
     * @return string
     */
    public static function encode(int $nanoseconds): string {
        return implode('', array_map(
            'self::char',
            str_split(self::padBits(decbin($nanoseconds), self::LENGTH * self::RADIX), self::RADIX)
        ));
    }

    /**
     * Reverts encoded string to int
     *
     * @param string $id
     * @return int
     */
    public static function decode(string $id): int {
        return bindec(implode('', array_map(
            'self::bits',
            str_split($id)
        )));
    }

    /**
     * Returns Universal time ID
     *
     * @return string
     */
    public static function get(): string {
        return self::encode(self::nanoseconds());
    }
}
