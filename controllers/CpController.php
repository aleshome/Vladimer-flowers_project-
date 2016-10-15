<?php
class CpController
{
    public function actionIsAdmin()
    {
        $admin = Cp::checkAdminRole(Session::get('user_id')); # Статический метод для проверки на вход Админа

        if($admin) {
            # Показываем главный файл админки иначе редирект на страницу авторизации тут она будет сдвоена
            include_once 'theme/shop/admin/dashboard/index.php';
        } else {
            Redirect::to('/login');
            #include_once 'engine/components/libs/error.php';
        }
        return true;
    }
}
