<?php
class RegisterController
{
    public function actionIndex()
    {
        include_once SKIN.'/register/index.php';
        return true;
    }

    public function actionDo()
    {
        if(isset($_POST['login']))
        {
            $data = array();

            $data['password'] = $_POST['password'];
            $repassword       = $_POST['repassword'];

            if($repassword == $data['password'])
            {
                $data['login'] = Security::escape($_POST['login']);
                $data['email'] = Security::escape($_POST['email']);

                $hash_unique_active_user = MD5::generateSalt(1743);

                DataBase::insertFromTable('tbl_user', array(
                    'login' => $data['login'],
                    'password' => MD5::hash($data['password']),
                    'hash'  => $hash_unique_active_user,
                    'email' => $data['email']
                ));
                # Отправка сообщения пользователю с подтверждением о регистрации

                $mail = new Mail();

                $mail->tos     = $data['email'];
                $mail->subject = 'Подтверждение регистрации на сайте ';
                $mail->message = 'Просто системное сообщение от скрипта что вам нужно перейти по ссылке для подтверждения своей регистрации\n <a href="/register/activateAccount">Подтвердите</a>';

                $mail->send(); # Go send

                Redirect::to('/');
            }
        } else {
            die('Не получилось зарегестрироватся вы не ввели свой будуещий логин...');
        }

        return true;
    }

    public function actionActivate()
    {
        include_once SKIN.'/register/active/index.php';
        
        return true;
    }

    public function actionDoActive()
    {
        $unique = $_POST['uniques'];

        if($unique == $_POST['uniques']) {
            # Основные параметры для дальнейшей работы скрипта
            $db   = DataBase::getConnection();
            $data = array();

            $data['email']    = $_POST['email'];
            $data['password'] = $_POST['password'];
            # Ниже переменная для сравнения из результатов на выход из Базы
            $lost_password = MD5::hash($data['password']);
            if(!empty($lost_password)) {
                $query_string = $db->prepare("SELECT * FROM tbl_user WHERE email = :mail_string");
                $query_string->execute(array(
                    ':mail_string' => $data['email']
                ));

                if($query_string->rowCount() > 0) {
                    $resultData = $query_string->fetch(PDO::FETCH_OBJ);

                    $userSecretHash = $resultData->hash;

                    $query_string_update = $db->prepare("UPDATE tbl_user SET user_active_account = '1' WHERE id = :user_id AND hash = :user_hash");
                    $query_string_update->execute(array(
                        ':user_id'   => $resultData->id,
                        ':user_hash' => $userSecretHash
                    ));

                    # Отправка сообщения пользователю с подтверждением о регистрации

                    $mail = new Mail();

                    $mail->tos     = $data['email'];
                    $mail->subject = 'Сообщение от сайта - ';
                    $mail->message = 'Вам прислано это сообщение так как вы успешно актевировали свой аккаунт в нашей системе, надеемся мы станем хорошими партнёрами в дальнейшем';

                    $mail->send(); # Go send

                    Redirect::to('/');
                } else {
                    exit('Не работает выборка в базу на дальнейшее получение информации для работы');
                    #include_once 'engine/components/libs/error.php';
                }
            } else {
                include_once 'engine/components/libs/error.php';
            }
        } else {
            #exit('No work ure code');
            include_once 'engine/components/libs/error.php';
        }
        return true;
    }
}
