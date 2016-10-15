<?php
# Это так лирика для работы с UTM метками 

function add_utm_to_email_body()
{
    $arr_utm = array(
        'name' => $CONTACT_NAME,
        'email' => isset($_POST['Email']) ? $_POST['Email'] : 'sd',
        'phone' => isset($phone) ? $_POST[$phone] : '',
        'utm_source' => isset($_COOKIE['utm_source']) ? $_COOKIE['utm_source'] : '',
        'utm_campaign' => isset($_COOKIE['utm_campaign']) ? $_COOKIE['utm_campaign'] : '',
        'utm_medium' => isset($_COOKIE['utm_medium']) ? $_COOKIE['utm_medium'] : '',
        'utm_term' => isset($_COOKIE['utm_term']) ? $_COOKIE['utm_term'] : '',
        'utm_content' => isset($_COOKIE['utm_content']) ? $_COOKIE['utm_content'] : '',
    );
    
    $message = '';
    
    if(!empty($arr_utm['utm_source'])) {
        $message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>utm_source - </b></td>
        <td>'.$arr_utm['utm_source'].'</td></tr>';
    }
    
    if(!empty($arr_utm['utm_campaign'])) {
        $message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>utm_campaign - </b></td>
        <td>'.$arr_utm['utm_campaign'].'</td></tr>';
    }
    
    if(!empty($arr_utm['utm_medium'])) {
        $message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>utm_medium - </b></td>
        <td>'.$arr_utm['utm_medium'].'</td></tr>';
    }
    
    if(!empty($arr_utm['utm_term'])) {
        $message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>utm_term - </b></td>
        <td>'.$arr_utm['utm_term'].'</td></tr>';
    }
    
    if(!empty($arr_utm['utm_content'])) {
        $message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>utm_content - </b></td>
        <td>'.$arr_utm['utm_term'].'</td></tr>';
    }
    
    $message .= "</table>";
    
    return $message;
}
