<?php
class Cryptography
{
    //@package class
    /**
     * Cryptography is a utility class that offers a number of general purpose cryptography
     */
    //Это указываеться что будет использоваться *Какой из методов шифрования по умолчанию
    public static function hash($input)
    {
        return PBKDF2::hash($input);
    }

    public static function compare($input, $hash, $isHash = false)
    {
        $version = substr($hash, 0, 8);

        if($isHash == true) {
            return $input == $hash;
        } elseif($version == 'PBKDF2v1') {
            return PBKDF2::compare($input, $hash);
        } elseif(strlen($hash) == 32) {
            return MD5::compare($input, $hash);
        } else {
            return false;
        }
    }

    public static function requireMigration($hash)
    {
        $version = substr($hash, 0, 8);

        if($version == PBKDF2::PREFIX) {
            return PBKDF2::requireMigration($hash);
        } else {
            return true;
        }
    }

    public static function generateSalt($length)
    {
        mt_srand(microtime(true)*100000 + memory_get_usage(true));
        return substr(sha1(uniqid(mt_rand(), true)), 0, $length);
    }
}
