<?php
# В данном случае вся работа моделей работает через "Автозагрузку" -> "По имени контроллера где она вызывается то есть в нутри контролера не надо подключать"
class CpAllSell
{
    public static function getList()
    {
        $db = DataBase::getConnection();

        return $db->query("SELECT * FROM tbl_order ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
    }

    public static function viewOrdertList($order_id)
    {
        $db = DataBase::getConnection();

        $query = $db->prepare("SELECT * FROM tbl_order WHERE id = :id");
        $query->execute(array(
            ':id' => $order_id
        ));

        if($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_OBJ);

            return $data;
        } else {
            return false;
        }
    }

    public static function updateOrderMenager($data, $id)
    {
        $db = DataBase::getConnection();

        $query = $db->prepare("UPDATE tbl_order SET status = :status WHERE id = :id");

        $query->execute(array(
            ':status' => $data['status'],
            ':id'     => $id
        ));
    }
}
