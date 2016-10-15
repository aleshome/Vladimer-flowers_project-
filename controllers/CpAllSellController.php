<?php
class CpAllSellController
{
    public function actionIndex()
    {
        $admin = Cp::checkAdminRole(Session::get('user_id'));

        if($admin) {
            $sell_list = CpAllSell::getList();
            # Показываем главный файл админки иначе редирект на страницу авторизации тут она будет сдвоена
            include_once 'theme/shop/admin/sell/list/index.php';
        } else {
            Redirect::to('/login');
            #include_once 'engine/components/libs/error.php';
        }
        return true;
    }

    public function actionDeleteSell($id)
    {
        if(isset($_POST['submit'])) {
            Product::deleteProductById($id);

            Redirect::to('/');
        }
        # Показывем админу страницу с подтверждением на удаление  так же можно просто в type="text" вводить пароль и проверять его тут и всё

        return true;
    }
    
    public function actionViewMoment($id)
    {
        $admin = Cp::checkAdminRole(Session::get('user_id'));

        if($admin) {
            $sell_list = CpAllSell::viewOrdertList($id);
            # Получение информации о том что именно купил пользователь на основе карзины
            # Получаем данные из карзины
                $productsInCart = $sell_list->orderList;
                # $order  это переменная $sell_list from json format
                $productsQuantity = json_decode($productsInCart, true);
                $productsIds = array_keys($productsQuantity);
                # gen array from products
                $products = Products::prodItemById($productsIds);
            # Показываем главный файл админки иначе редирект на страницу авторизации тут она будет сдвоена
            include_once 'theme/shop/admin/sell/viewItemSell/index.php';
        } else {
            Redirect::to('/login');
            #include_once 'engine/components/libs/error.php';
        }
        return true;
    }

    public function actionEdit($post_id)
    {
        $data = array();

        $data['status'] = Security::is_integer((int) $_POST['status']);

        CpAllSell::updateOrderMenager($data, $post_id);

        Redirect::to('/cpAllSell');

        return true;
    }
}
