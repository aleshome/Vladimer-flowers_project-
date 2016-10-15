<?php
class KartaSiteController
{
    public function actionIndex()
    {
        include_once SKIN.'/sitemup/index.php';

        return true;
    }
}
