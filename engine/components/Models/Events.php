<?php
class Events
{
    public static function getList()
    {
        $db = DataBase::getConnection();

        return $db->query("SELECT * FROM haw_whe_job_list")->fetchAll(PDO::FETCH_OBJ);
    }
}
