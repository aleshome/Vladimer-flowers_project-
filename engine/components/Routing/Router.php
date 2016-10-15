<?php

/**
 * Class Router - отвечает за построение маршрутов самого сайта только с небольшой помощью некого массива из engine/config/routes.php
 */
class Router
{
    private $routes;
    
    public function __construct()
    {
        $routes = ROOT.'/engine/config/routes.php';

        if(is_file($routes)) {
            $this->routes = include_once $routes;
        } else throw new Exception('Файл кнфигурации с маршрутами для системы не подключён...');
    }
    
    private function getUrl()
    {
        if(!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
    
    public function run()
    {
        # print_r($this->routes);
        $uri = $this->getUrl();

        foreach($this->routes as $uriPattern => $path)
        {
            if(preg_match("~$uriPattern~", $uri))
            {
                $internalRoutes = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoutes);

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                $controllerFileName = ROOT.'/controllers/'.$controllerName.'.php';

                if(file_exists($controllerFileName))
                {
                    include_once $controllerFileName;
                }
                # Create obj amd method's load controller
                $parameters = $segments;

                $controllerObject = new $controllerName;

                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if($result != null) {
                    break;
                } else {
                    include_once ROOT.'/engine/components/libs/error.php';
                }
            }
        }
    }
}
