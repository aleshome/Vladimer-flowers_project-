<?php
class ServiceController
{
    public function actionDeliver()
    {
        include_once SKIN.'/service/deliver/index.php';
        
        return true;
    }

    public function actionPayment()
    {
        include_once SKIN.'/service/payment/index.php';
        
        return true;
    }
    
    public function actionZakaz()
    {
        include_once SKIN.'/service/hauorder/index.php';
        return true;
    }
}
