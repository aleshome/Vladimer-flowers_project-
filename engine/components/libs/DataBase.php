<?php
/**
 * Created by PhpStorm. 
*/
class DataBase
{
    private static $db_host = 'localhost';
    private static $db_name = 'VladimerSite';
    private static $db_user = 'root';
    private static $db_pass = 'root';

    private static $_instance = null;

    private function __construct() {}
    private function __clone(){}

    public static function getConnection()
    {
        if(!isset(self::$_instance))
        {
            try {
                self::$_instance = new PDO('mysql:host='.self::$db_host.';dbname='.self::$db_name, self::$db_user, self::$db_pass,
                    array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    ));
            } catch (PDOException $e) {
                throw new Exception('Ошибка соеденения с базой данных'.$e->getMessage());
            }
        }

        return self::$_instance;
    }
    # так же статический метод для вставки данных в таблицу 
    public static function insertFromTable($table, $data)
    {
        ksort($data);

        $fieldName  = implode('`, `', array_keys($data));
        $fieldValue = ':' . implode(', :', array_keys($data));

        $query = DataBase::getConnection()->prepare("INSERT INTO $table (`$fieldName`) VALUES ($fieldValue)");

        foreach($data as $key => $value):
            $query->bindValue(":$key", $value);
        endforeach;

        $query->execute();
    }
}
