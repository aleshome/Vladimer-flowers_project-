<?php
class NewsController
{
    public function actionIndex($param = true)
    {
        # Load template folder / file
        $paramInt = (int) $param;
        include_once SKIN.'/news/list/index.php';
        
        return true;
    }
    
    public function actionView($alias)
    {
        $alias = Security::escape($alias);

        $newsObj = News::itemAlias($alias);
        News::UpdateUserViews($alias);

        include_once SKIN.'/news/item/index.php';
        
        return true;
    }
    
    public function actionArchive($date)
    {
        # Сдесь идёт запрос на новости которые в архиее логика такая если новости больше 2-х мес. тогда они в архив
        
        return true;
    }
}
