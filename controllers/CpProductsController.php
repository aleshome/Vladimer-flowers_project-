<?php
class CpProductsController
{
    public function actionIndex()
    {
        $admin = Cp::checkAdminRole(Session::get('user_id'));

        if($admin) {
            $product_list = CpProducts::getListProduct();
            # Показываем главный файл админки иначе редирект на страницу авторизации тут она будет сдвоена
            include_once 'theme/shop/admin/products/list/index.php';
        } else {
            Redirect::to('/login');
            #include_once 'engine/components/libs/error.php';
        }

        return true;
    }

    public function actionAdd()
    {
        $admin = Cp::checkAdminRole(Session::get('user_id'));

        if($admin) {
            # Показываем главный файл админки иначе редирект на страницу авторизации тут она будет сдвоена
            include_once 'theme/shop/admin/products/add/index.php';
        } else {
            Redirect::to('/login');
            #include_once 'engine/components/libs/error.php';
        }

        return true;
    }

    public function actionUpdateAdd()
    {
        $data = array();

        $admin = Cp::checkAdminRole(Session::get('user_id'));

        if($admin) {
            # Делаем запросы в модель
            $data['name'] = $_POST['name'];
            $data['meta_desc'] = $_POST['meta_desc'];
            $data['meta_key']  = $_POST['meta_key'];
            $data['cat_name']  = $_POST['cat_name'];
            # Второй блок запроса данных
            $data['price']      = (int) $_POST['price'];
            $data['last_price'] = (int) $_POST['last_price'];
            $data['image']      = $_POST['image'];
            $data['image_2']    = $_POST['image_2'];
            $data['image_3']    = $_POST['image_3'];
            $data['image_4']    = $_POST['image_4'];
            $data['image_5']    = $_POST['image_5'];

            $data['description']    = Security::escape($_POST['description']);
            $data['status_deliver'] = (int) Security::is_integer($_POST['status_deliver']);
            $data['alias']          = $_POST['alias'];
            $data['cat_id']         = $_POST['cat_id'];
            # Третья группа запроса на получние данных
            $data['sostav_1_name']  = $_POST['sostav_1_name'];
            $data['sostav_1_param'] = $_POST['sostav_1_param'];
            $data['sostav_2_name']  = $_POST['sostav_2_name'];
            $data['sostav_2_param'] = $_POST['sostav_2_param'];
            $data['sostav_3_name']  = $_POST['sostav_3_name'];
            $data['sostav_3_param'] = $_POST['sostav_3_param'];
            $data['sostav_4_name']  = $_POST['sostav_4_name'];
            $data['sostav_4_param'] = $_POST['sostav_4_param'];
            $data['sostav_5_name']  = $_POST['sostav_5_name'];
            $data['sostav_5_param'] = $_POST['sostav_5_param'];
            $data['sostav_6_name']  = $_POST['sostav_6_name'];
            $data['sostav_6_param'] = $_POST['sostav_6_param'];
            $data['sostav_7_name']  = $_POST['sostav_7_name'];
            $data['sostav_7_param'] = $_POST['sostav_7_param'];
            $data['sostav_8_name']  = $_POST['sostav_8_name'];
            $data['sostav_8_param'] = $_POST['sostav_8_param'];
            $data['prod_width']     = $_POST['prod_width'];
            $data['prod_height']    = $_POST['prod_height'];
            $data['show_home']      = (int) $_POST['show_home'];

            CpProducts::insertParam($data);
            Redirect::to('/cpProducts');
        } else {
            Redirect::to('/login');
        }


        return true;
    }
}
