<?php
class CpProducts
{
    public static function getListProduct()
    {
        $db = DataBase::getConnection();

        return $db->query("SELECT * FROM tbl_product")->fetchAll(PDO::FETCH_OBJ);
    }

    public static function insertParam($data)
    {
        DataBase::insertFromTable('tbl_product', array(
            'name' => $data['name'],
            'meta_desc' => $data['meta_desc'],
            'meta_key' => $data['meta_key'],
            'cat_name' => $data['cat_name'],
            'price' => $data['price'],
            'last_price' => $data['last_price'],
            'image' => $data['image'],
            'image_2' => $data['image_2'],
            'image_3' => $data['image_3'],
            'image_4' => $data['image_4'],
            'image_5' => $data['image_5'],
            'description' => $data['description'],
            'status_deliver' => $data['status_deliver'],
            'alias' => $data['alias'],
            'cat_id' => $data['cat_id'],
            'sostav_1_name' => $data['sostav_1_name'],
            'sostav_1_param' => $data['sostav_1_param'],
            'sostav_2_name' => $data['sostav_2_name'],
            'sostav_2_param' => $data['sostav_2_param'],
            'sostav_3_name' => $data['sostav_3_name'],
            'sostav_3_param' => $data['sostav_3_param'],
            'sostav_4_name' => $data['sostav_4_name'],
            'sostav_4_param' => $data['sostav_4_param'],
            'sostav_5_name' => $data['sostav_5_name'],
            'sostav_5_param' => $data['sostav_5_param'],
            'sostav_6_name' => $data['sostav_6_name'],
            'sostav_6_param' => $data['sostav_6_param'],
            'sostav_7_name' => $data['sostav_7_name'],
            'sostav_7_param' => $data['sostav_7_param'],
            'sostav_8_name' => $data['sostav_8_name'],
            'sostav_8_param' => $data['sostav_8_param'],
            'prod_width' => $data['prod_width'],
            'prod_height' => $data['prod_height'],
            'show_home' => $data['show_home']
        ));
    }
}
