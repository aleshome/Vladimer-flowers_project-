<?php
class LoginController
{
    public function actionIndex()
    {
        if(@$_SESSION['logged'] == 1) {
            Redirect::to('/UserRoom');
        } else {
            include_once SKIN.'/login/index.php';
        }

        return true;
    }

    public function actionDoActive()
    {
        $db   = DataBase::getConnection();
        $data = array();

        $unique_key = Security::escape($_POST['uniques']);

        $data['key'] = $_POST['uniques'];

        if($unique_key == $data['key']) {
            $data['login']    = Security::escape($_POST['login']);
            $data['password'] = MD5::hash($_POST['password']);

            $query = $db->prepare("SELECT * FROM tbl_user WHERE login = :login AND password = :password AND user_active_account = '1'");
            $query->execute(array(
                ':login'    => $data['login'],
                ':password' => $data['password']
            ));

            $userItemData = $query->fetch(PDO::FETCH_OBJ);

            $userSessionUpdate = $db->prepare("UPDATE tbl_user SET last_login = NOW() WHERE login = :login AND id = :id");
            $userSessionUpdate->execute(array(
                ':login' => $data['login'],
                ':id'    => $userItemData->id
            ));

            if(!empty($userItemData)) {
                Session::set('logged', '1');
                Session::set('login', $userItemData->login);
                Session::set('user_id', $userItemData->id);
                Session::set('user_email', $userItemData->email);
                
                Redirect::to('/UserRoom');
            } else {
                include_once 'engine/components/libs/error.php';
            }
        } else {
            exit('Переданные параметры секретно не совпадают...');
        }

        return true;
    }

    public function actionLogout()
    {
        if(isset($_SESSION['logged'])) {
            # clear user data moment here
            $userId = $_SESSION['user_id'];
            # Model query
            $dateNow = date('Y-m-d H:i:s');
            $db = DataBase::getConnection();

            $query = $db->prepare("UPDATE tbl_user SET last_logout = :datea WHERE id = :user_id");

            $query->execute(array(
                ':user_id' => $userId,
                ':datea'   => $dateNow
            ));
            # basic user param's 
            unset($_SESSION['logged']);
            unset($_SESSION['login']);
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);

            Redirect::to('/login');
        } else {
            Redirect::to('/');
        }

        return true;
    }

    # 9k6vkcbd last login from account ru
}
