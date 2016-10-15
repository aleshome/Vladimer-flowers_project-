<?php
class Validator
{
    public static function escape($string)
    {
        return htmlentities(trim($string), ENT_QUOTES, 'UTF-8');
    }

    public static function is_integer($data)
    {
        if (is_numeric($data)) {
            echo "";
        } else {
            return false;
        }

        return $data;
    }
    //Валидатор простенький с небольшим описанием но работает

    public static function checkForm($params,$method)
    {
        /*

        $params - Массив параметров/полей формы которые должны быть проверены
        Пример:
        $params = array(
            'name'=>'string',
            'lastname'=>'string',
            'email'=>'email',
            'zipcode'=>'integer'
        );

        $method - метод отправки формы, POST или GET

        */

        if($method == 'POST') $DATA = $_POST;
        if($method == 'GET') $DATA = $_GET;

        if(empty($DATA)) return FALSE;

        $ERR_FIELDS = array();	// массив для хранения названий полей заполненных с ошибками
        $i = 0;

        foreach($params as $fieldName => $fieldType):
            if(!isset($DATA[$fieldName]) || empty($DATA[$fieldName])) {
                $ERR_FIELDS[$i]['fieldName'] = $fieldName;
                $ERR_FIELDS[$i]['reason'] = 'поле не заполнено<br/>';
                $i++;
            }
            else
            {
                // проверка цифрового поля
                if($fieldType == 'integer') {
                    if(!is_numeric($DATA[$fieldName])) {
                        $ERR_FIELDS[$i]['fieldName'] = $fieldName;
                        $ERR_FIELDS[$i]['reason'] = 'поле дожно быть числом<br/>';
                        $i++;
                    }
                }
                // проверка email
                if($fieldType == 'email') {
                    if(!filter_var($DATA[$fieldName],FILTER_VALIDATE_EMAIL)) {
                        $ERR_FIELDS[$i]['fieldName'] = $fieldName;
                        $ERR_FIELDS[$i]['reason'] = 'поле дожно быть email адресом<br/>';
                        $i++;
                    }
                }
                // проверка string
                if($fieldType == 'string') {
                    $cleanedField = strip_tags($DATA[$fieldName]);
                    $cleanedField = trim($cleanedField);
                    $DATA[$fieldName] = $cleanedField;
                }
            }
        endforeach;

        // формируем ответ
        if(count($ERR_FIELDS) == 0) {
            $ANSWER['status'] = '1';
            $ANSWER['status-text'] = 'Форма заполнена без ошибок';
            $ANSWER['data'] = $DATA;
        }
        else {
            $ANSWER['status'] = '0';
            $ANSWER['status-text'] = 'Форма заполнена с ошибками';
            $ANSWER['errors'] = $ERR_FIELDS;
        }

        return $ANSWER;
    }
}
