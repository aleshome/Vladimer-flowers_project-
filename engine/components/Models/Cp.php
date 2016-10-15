<?php
class Cp
{
    public static function checkAdminRole($user_id)
    {
        $db = DataBase::getConnection();

        $query = $db->prepare("SELECT * FROM tbl_user WHERE id = :user_id");

        $query->execute(array(
            ':user_id' => $user_id
        ));

        if($query->rowCount() > 0) {
            $user_data = $query->fetch(PDO::FETCH_OBJ);

            if($user_data->us_role == 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            Redirect::to('/login');
        }
    }
}
