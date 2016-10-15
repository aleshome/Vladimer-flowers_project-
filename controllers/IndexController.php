<?php
/**
 * This controller is front-controller
 */
class IndexController
{
    public function actionHome()
    {
        #$string = 'password';
        #echo MD5::hash($string);
        include_once SKIN.'/homepage/index.php';
        
        return true;
    }
}
