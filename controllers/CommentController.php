<?php
/*---------------------------------------------------------------------------
* @Module Name: Comment
* @Description: Comment for news module and product item's
* @Version: 1.0
* @Author: AlexSoftInc
* @LiveStreet Version: 0.3.1
* @File Name: CommentController.php
* @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*----------------------------------------------------------------------------
*/
class CommentController
{
	function actionPostData()
	{
		$data = array();

		$data['username'] 	  = Security::escape($_POST['username']);
		$data['user_email']   = Security::escape($_POST['user_email']);
		$data['datesend']     = $_POST['datesend'];
		$data['cpmment_user'] = Security::escape($_POST['cpmment_user']);
		$data['post_id'] 	  = (int) $_POST['post_id'];

		$insert = DataBase::insertFromTable('tbl_comment_news', array(
			'username' 	   => $data['username'],
			'user_email'   => $data['user_email'],
			'datesend'     => $data['datesend'],
			'cpmment_user' => $data['cpmment_user'],
			'post_id'      => $data['post_id'],
		));

		Redirect::to('/news');

		return true;
	}

	public function actionCommentProduct($param)
	{
		$data = array();

		$data['username'] 	  = Security::escape($_POST['username']);
		$data['rating_star_product']   = Security::escape($_POST['rating_star_product']);
		$data['datesend']     = $_POST['datesend'];
		$data['cpmment_user'] = Security::escape($_POST['cpmment_user']);
		$data['comment_product_id'] 	  = (int) $_POST['comment_product_id'];

		$insert = DataBase::insertFromTable('tbl_comment_news', array(
			'username' 	   => $data['username'],
			'rating_star_product'   => $data['rating_star_product'],
			'datesend'     => $data['datesend'],
			'cpmment_user' => $data['cpmment_user'],
			'comment_product_id'      => $data['comment_product_id'],
		));

		Redirect::to('/');

		return true;
	}
} 
