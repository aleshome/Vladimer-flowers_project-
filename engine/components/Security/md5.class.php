<?php
class MD5 extends Cryptography
{
    public static function hash($input)
    {
        return md5($input);
    }

    public static function file($input)
    {
        return md5_file($input);
    }

    public static function compare($input, $hash, $isHash = false)
    {
        return ($hash == self::hash($input));
    }
}
