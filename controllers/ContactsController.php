<?php
class ContactsController
{
    public function actionIndex()
    {
        include_once SKIN.'/contact/index.php';
        
        return true;
    }
    
    public function actionPostM()
    {
        $insert = DataBase::insertFromTable('tbl_user_call', array(
            'namezvon'     => $_POST['namezvon'],
            'telzvon'   => $_POST['telzvon'],
        ));

        Redirect::to('/');
        
        return true;
    }

    public function actionMomentView()
    {
        $insert = DataBase::insertFromTable('tbl_contact_form', array(
            'name_1'     => $_POST['name_1'],
            'telefon'   => $_POST['telefon'],
            'dop'       => $_POST['dop'],
        ));

        Redirect::to('/');

        return true;
    }
}
