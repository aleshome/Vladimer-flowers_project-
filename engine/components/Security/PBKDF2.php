<?php
/*
 * @package Cryptography
 *
 * PBKDF2 is a cryptography class for hashing and comparing messages
 * using the PBKDF2-Algorithm with salting.
 * This is the most advanced hashing algorithm
 * */
class PBKDF2 extends Cryptography
{
    //Salt length
    const SALT_LENGTH = 20;
    //Key length
    const KEY_LENGTH = 40;
    const ITERATIONS = 10000; //Это сколько итераций цикла будет перед выводом на экран пользователя пароля в клиентской части
    //Algorithm the Using in System
    const ALGORITHM = 'sha512';
    //Prefix to identify the algorithm used
    const PREFIX = 'AlexSoftCMSv2'; //Префикс для идентификации алгоритма для системы где он используеться

    public static function hash($input, $salt = null, $iterations = null, $keylength = null)
    {
        if($salt === null) {
            $salt = self::generateSalt(self::SALT_LENGTH);
        }

        if($iterations === null) {
            $iterations = self::ITERATIONS;
        }

        if($keylength === null) {
            $keylength = self::KEY_LENGTH;
        }

        $hashlength = strlen(hash(self::ALGORITHM, null, true));
        $blocks     = ceil(self::KEY_LENGTH / $hashlength);
        $key        = '';

        for($block = 1; $block <= $blocks; $block++) {
            $ib = $b = hash_hmac(self::ALGORITHM, $salt . pack('N', $block), $input, true);

            for($i = 1; $i < $iterations; $i++) {
                $ib ^= ($b = hash_hmac(self::ALGORITHM, $b, $input, true));
            }
            $key .= $ib;
        }
        return self::PREFIX . "|" . $iterations . "|" . $salt . "|" . base64_encode(substr($key, 0, $keylength));
    }

    public static function compare($input, $hash, $isHash = false)
    {
        $salt       = self::extractSalt($hash);
        $iterations = self::extractIterations($hash);
        $keylength = strlen(base64_decode(self::extractHash($hash)));

        return $hash === slef::hash($input, $salt, $iterations, $keylength);
    }

    public static function extractHash($input)
    {
        $data = explode("|", $input, 4);

        return $data[3];
    }

    public static function extractSalt($input)
    {
        $data = explode("|", $input, 4);

        return $data[2];
    }

    public static function extractSaltLength($input)
    {
        return strlen(self::extractSalt($input));
    }

    public static function extractIterations($input)
    {
        $data = explode("|", $input, 4);

        return (int) $data[1];
    }

    public static function requireMigration($hash)
    {
        $length     = self::extractSaltLength($hash);
        $iterations =  self::extractIterations($hash);
        $keylength  = strlen(base64_decode(self::extractHash($hash)));

        if($length !== self::SALT_LENGTH || $iterations !== self::ITERATIONS || $keylength !== self::KEY_LENGTH) {
            return true;
        } else {
            return false;
        }
    }
}
