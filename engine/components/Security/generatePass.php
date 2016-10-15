<?php
define('LENGTH',10);

function get_pass() {
    /*
    $str = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";

    $str_lenght = strlen($str) - 1;

    $str_gen = '';

    for($i = 0; $i < LENGTH; $i++) {

        $x = mt_rand(0,$str_lenght);

        if($i != 0 ) {
            if($str_gen[strlen($str_gen) - 1] == $str[$x]) {
                $i--;
                continue;
            }
        }
        $str_gen .= $str[$x];
    }

    return $str_gen;

    */
    $gl = array('y','Y','e','E','u','U','i','I','o','O','a','A');

    $so = array('w','W','r','R','t','T','p','P','s','S','d','D','f','F','g','G','h','H','j','J','k','K','l','L','z','Z','x','X','c','C','v','V','b','B','n','N','m','M');

    $result = '';

    $v = mt_rand(1,20);
    if($v > 9) {
        ///gl-so
        for($i = 0; $i < LENGTH; $i+=2 ) {
            $in = mt_rand(0,count($gl)-1);
            $result .= $gl[$in];

            $in = mt_rand(0,count($so)-1);
            $result .= $so[$in];
        }
    }
    else {
        //so-gl
        for($j = 0; $j < LENGTH; $j+=2 ) {

            $in = mt_rand(0,count($so)-1);
            $result .= $so[$in];

            $in = mt_rand(0,count($gl)-1);
            $result .= $gl[$in];

        }
    }

    return $result;
}
