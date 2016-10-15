<?php
class ProductsController
{
    public function actionIndex()
    {
        echo 'Главная страница каталога продукции <br/>   ';
        
        $prodObj = Products::getList();
        
        include_once SKIN.'/products/list/index.php';
        
        return true;
    }
    
    public function actionViews($alias)
    {
        $alias = Security::escape($alias);
        
        $prodObj = Products::prodItem($alias);
        Products::updateViews($alias);
        
        include_once SKIN.'/products/item/index.php';
        
        return true;
    }
}
