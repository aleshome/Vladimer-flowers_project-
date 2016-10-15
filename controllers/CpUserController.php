<?php
class CpUserController
{
    public function actionIndex()
    {
        $admin = Cp::checkAdminRole(Session::get('user_id'));

        if($admin) {
            $user_list = CpUser::getList();
            # Показываем главный файл админки иначе редирект на страницу авторизации тут она будет сдвоена
            include_once 'theme/shop/admin/user/list/index.php';
        } else {
            Redirect::to('/login');
            #include_once 'engine/components/libs/error.php';
        }
        return true;
    }

    public function actionEdit($id)
    {
        $admin = Cp::checkAdminRole(Session::get('user_id'));

        if($admin) {
            $bay_user_list = CpUser::bayList($id);
            $user_item = CpUser::getUserId($id);
            # Показываем главный файл админки иначе редирект на страницу авторизации тут она будет сдвоена
            include_once 'theme/shop/admin/user/edit/index.php';
        } else {
            Redirect::to('/login');
            #include_once 'engine/components/libs/error.php';
        }

        return true;
    }

    public function actionUpdate($user_id)
    {
        $data = array();
        # Массив входных данных для передачи в модель
        $data['login']                = Security::escape($_POST['login']);
        $data['email']                = Security::escape($_POST['email']);
        $data['user_name']            = Security::escape($_POST['user_name']);
        $data['user_last_name']       = Security::escape($_POST['user_last_name']);
        $data['user_deliver_region']  = Security::escape($_POST['user_deliver_region']);
        $data['user_deliver_address'] = Security::escape($_POST['user_deliver_address']);
        $data['user_phone']           = Security::escape($_POST['user_phone']);
        $data['name_user_deliver']    = Security::escape($_POST['name_user_deliver']);
        $data['phone_client_deliver'] = Security::escape($_POST['phone_client_deliver']);

        CpUser::updateStaticInfoMenager($data, $user_id);

        Redirect::to('/cpUser');

        return true;
    }
}
