<?php
class Hash
{
    /*
     * @param string $algo the algoritm (md5, sha1, sha256, whir:pool, etc)
     * @param string $data the data to encode
     * @param string $salt the salt (this should be the same throughout the system probably)
     * @return string the hashed/salted data
    */
    public static function create($algo, $data, $salr)
    {
        $context = hash_init($algo, HASH_HMAC, $salr);

        hash_update($context, $data);

        return hash_final($context);
    }
}
