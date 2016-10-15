<?php
class CategoryController
{
    public function actionCatname($name, $param = true)
    {
        $per_page = (int) $param;
        $name = Security::escape($name);

        include_once SKIN.'/catalog/category/list/index.php';
        
        return true;
    }

    public function actionProduct($param)
    {
        $item = Products::prodItem($param);
        
        include_once SKIN.'/catalog/product/item/index.php';

        return true;
    }
}
