<?php
# Это просто файл модели для новостей которые поидее должны загружатся автоматом [вот и проверить надо]
class News
{
    const TBL = 'news';

    public static function getList()
    {
        $db = DataBase::getConnection();

        $table = self::TBL;

        $query = $db->query("SELECT * FROM tbl_{$table} ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);

        return $query;
    }
    
    public static function itemAlias($alias)
    {
        $db = DataBase::getConnection();

        $table = self::TBL;

        $query = $db->prepare("SELECT * FROM tbl_{$table} WHERE alias = :alias AND news_archive = '0'");

        $query->execute(array(
            ':alias' => $alias
        ));

        if($query->rowCount() > 0)
        {
            $data = $query->fetch(PDO::FETCH_OBJ);

            return $data;
        } else {
            include_once ROOT.'/engine/components/libs/error.php';
        }
    }

    public static function UpdateUserViews($alias)
    {
        $db = DataBase::getConnection();

        $table = self::TBL;

        $query = $db->prepare("UPDATE tbl_{$table} SET news_views = news_views + 1 WHERE alias = :alias");

        $query->execute(array(
            ':alias' => $alias
        ));
    }
}
