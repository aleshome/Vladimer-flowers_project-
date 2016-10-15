<?php
class Products
{
    const TBL = 'product';
    
    public static function getList($name)
    {
        $db = DataBase::getConnection();

        $table = self::TBL;
        
        $query = $db->prepare("SELECT * FROM tbl_{$table} WHERE cat_name = :name_category");

        $query->execute(array(
           ':name_category' => $name
        ));

        if($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_OBJ);
            #print_r($data);
            return $data;
        } else {
            exit("В этой категории нету цветов, попробуйте выбрать другую");
        }
    }
    
    public static function prodItem($alias)
    {
        $db = DataBase::getConnection();
        
        $table = self::TBL;
        
        $query = $db->prepare("SELECT * FROM tbl_{$table} WHERE alias = :alias");
        
        $query->execute(array(
            ':alias' => $alias
        ));
        
        if($query->rowCount() > 0)
        {
            $data = $query->fetch(PDO::FETCH_OBJ);
            
            return $data;
        } else {
            include_once ROOT.'/engine/components/libs/error.php';
        }
    }

    public static function prodItemById($isArray)
    {
        $products = array();

        $db = DataBase::getConnection();

        $idsString = implode(',', $isArray);

        $sql = "SELECT * FROM tbl_product WHERE status_sell = '1' AND id IN ($idsString)";

        $result = $db->query($sql);
        
        $i = 0;

        while($row = $result->fetch(PDO::FETCH_OBJ)):
            $products[$i]['id']       = $row->id;
            $products[$i]['art_code'] = $row->art_code;
            $products[$i]['name']     = $row->name;
            $products[$i]['price']    = $row->price;
            $products[$i]['image']    = $row->image;
            $products[$i]['alias']    = $row->alias;
            $i++;
        endwhile;

        return $products;
    }

    public static function updateViews($alias)
    {
        $db = DataBase::getConnection();

        $table = self::TBL;

        $query = $db->prepare("UPDATE tbl_{$table} SET prod_views = prod_views + 1 WHERE alias = :alias");

        $query->execute(array(
            ':alias' => $alias
        ));
    }
}
