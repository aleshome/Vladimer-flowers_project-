<?php
function __autoload($class)
{
    # Список возможно подключаемых дирректорий
    $array_paths = array(
        '/engine/components/Models/', # Знаю от рута проекта но все же работает на ура 
    ); 
    
    foreach($array_paths as $path):
        $path = ROOT . $path . $class . '.php';
            if(is_file($path)) {
                include_once $path;
            }
    endforeach;
}
