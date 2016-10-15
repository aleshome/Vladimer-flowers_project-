<?php
class SHA1 extends Cryptography
{
    public static function hash($input)
    {
        return sha1($input);
    }

    /**
     * Uses 'SHA1' to create a hash from the contents of a file
     * @param string $input;
     * @return string
     * the hashed string
     */

    public static function file($input)
    {
        return sha1_file($input);
    }

    /**
     * Compares a given hash with a cleantext password.
     * @param $input
     * the cleantext password.
     * @param $hash
     * the hash the password should be checked against
     * @param boolean $isHash
     * @return boolean
     * the result of the comparison
     */

    public static function compare($input, $hash, $isHash = false)
    {
        return ($hash == self::hash($input));
    }
}
