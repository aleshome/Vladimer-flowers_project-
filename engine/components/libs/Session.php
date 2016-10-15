<?php
# Очень полезный класс и часто выручает когда надо что то быстро проверить 

class Session
{

    public static function init()
    {
        @session_start();
    }



    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }



    public static function get($key)
    {
        return @$_SESSION[$key];
    }



    public static function logout()
    {
        unset($_SESSION);
        session_destroy();

        Redirect::to('index');
    }

    public static function isAuth($sess)
    {
        $sess = Session::get('logged');
        
        if($sess == false) {

            Redirect::to('login');

        } else return true;
    }
}
