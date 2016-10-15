<?php
class PartnerController
{
    public function actionIndex()
    {
        include_once SKIN.'/partners/list/index.php';
        
        return true;
    }
    
    public function actionCompany($name)
    {
        include_once SKIN.'/partners/item/index.php';
        
        return true;
    }
}
