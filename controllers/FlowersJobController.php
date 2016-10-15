<?php
class FlowersJobController
{
    public function actionGallery()
    {
        include_once SKIN .'/gallery/florist/index.php';
        return true;
    }
}
