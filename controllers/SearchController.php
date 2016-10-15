<?php
class SearchController
{
    public function actionIndex()
    {
        include_once SKIN.'/searching/index.php';

        return true;
    }

    public function actionResData() 
    {
    	$data = array();

    	$data['price_end'] = $_POST['price_end'];

        $db = DataBase::getConnection();

    	$query = $db->prepare("SELECT * FROM tbl_product WhERE `price` LIKE :someprice OR `price` < :someprice OR `price` > :someprice ORDER BY id DESC LIMIT 8");
    	$query->execute(array(
    		':someprice' => $data['price_end']
		));

		$result = $query->fetchAll(PDO::FETCH_OBJ);

		include_once SKIN.'/searching/result/index.php';
    	return true;
    }
}
