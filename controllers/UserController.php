<?php
class UserController
{
    public function actionRoom()
    {
        # Сделать проверку как на LoginController только в обратном порядке и вообще при выходе статистика должна вестись когда чел вошёл и вышел
        include_once SKIN.'/user/homepage/index.php';
        
        return true;
    }

    public function actionPayment()
    {
    	include_once SKIN.'/user/payments/index.php';

    	return true;
    }

    public function actionHiSkidka()
    {
		include_once SKIN.'/user/skidka/index.php';

    	return true;
    }
    
    public function actionProfileEdit()
    {
        include_once SKIN .'/user/update/index.php';
        
        return true;
    }
    
    public function actionUpdatePro()
    {
        print_r($_POST);
        $db = DataBase::getConnection();
        $data = array();
        
        $data['login'] = Security::escape($_POST['login']);
        $data['email'] = Security::escape($_POST['email']);
        $data['user_name'] = Security::escape($_POST['user_name']);
        $data['user_last_name'] = Security::escape($_POST['user_last_name']);
        $data['user_date_of_breach'] = Security::escape($_POST['user_date_of_breach']);
        $data['user_deliver_region'] = Security::escape($_POST['user_deliver_region']);
        $data['user_deliver_address'] = Security::escape($_POST['user_deliver_address']);
        $data['user_phone'] = Security::escape($_POST['user_phone']);
        $data['name_user_deliver'] = Security::escape($_POST['name_user_deliver']);
        $data['phone_client_deliver'] = Security::escape($_POST['phone_client_deliver']);
        $data['user_id'] = (int) $_POST['user_name'];
        
        
        return true;
    }
}
