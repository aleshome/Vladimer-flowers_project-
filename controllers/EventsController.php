<?php
class EventsController
{
    public function actionIndex()
    {
        $event = Events::getList();

        include_once SKIN.'/events/list/index.php';
        return true;
    }
}
