<?php
class CpUser
{
    public static function getList()
    {
        $db = DataBase::getConnection();
        
        return $db->query("SELECT email,login,last_login,id FROM tbl_user")->fetchAll(PDO::FETCH_OBJ);;
    }

    public static function getUserId($user_id)
    {
        $db = DataBase::getConnection();

        $query = $db->prepare("SELECT * FROM tbl_user WHERE id = :user_id");
        $query->execute(array(
            ':user_id' => $user_id
        ));

        if($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_OBJ);
            
            return $data;
        } else {
            throw new Exception('Такого пользовтаеля не существует вы ошиблись.');
        }
    }

    public static function bayList($user_id)
    {
        $db = DataBase::getConnection();

        $query = $db->prepare("SELECT * FROM tbl_user_order WHERE user_id = :id");
        $query->execute(array(
            ':id' => $user_id
        ));

        if($query->rowCount() > 0) {
            $data = $query->fetchAll(PDO::FETCH_OBJ);

            return $data;
        } 
    }

    public static function updateStaticInfoMenager($data, $id)
    {
        $db = DataBase::getConnection();

        $query = $db->prepare("UPDATE tbl_user SET login = :login, email = :email, user_name = :user_name, user_last_name = :user_last_name, user_deliver_region = :user_deliver_region, user_deliver_address = :user_deliver_address, user_phone = :user_phone, name_user_deliver = :name_user_deliver, phone_client_deliver = :phone_client_deliver WHERE id = :id");

        $query->execute(array(
            ':login'                => $data['login'],
            ':email'                => $data['email'],
            ':user_name'            => $data['user_name'],
            ':user_last_name'       => $data['user_last_name'],
            ':user_deliver_region'  => $data['user_deliver_region'],
            ':user_deliver_address' => $data['user_deliver_address'],
            ':user_phone'           => $data['user_phone'],
            ':name_user_deliver'    => $data['name_user_deliver'],
            ':phone_client_deliver' => $data['phone_client_deliver'],
            ':id'                   => (int) $id
        ));
    }
}
