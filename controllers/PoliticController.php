<?php
class PoliticController
{
    public function actionIndex()
    {
        include_once SKIN.'/politic/index.php';
        
        return true;
    }
}
