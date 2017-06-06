<?php

class Router{
    private $routes;
    public function __construct()
    {
        $routesPath= ROOT."/config/routes.php";
        $this->routes=include($routesPath);
                
    }
    private function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI']))
        {
            return trim($_SERVER['REQUEST_URI'],'/'); 
        }
    }
    public function run()
    {
        $url=$this->getURI();
       foreach($this->routes as $UrlPattern=>$path) //пееребираем массив с роутами
       {
           if(preg_match("~$UrlPattern~",$url))
           {
                $arr=explode ('/',$path);
                $controller=array_shift($arr)."Controller"; //определяем контроллер
                $action="action".array_shift($arr); //определяем метод обработки полученных данных
                $pathController=ROOT.'/Controllers/'.$controller.'.php';
                if(file_exists($pathController))
                { 
                    include_once($pathController);//подключаем файл контроллера
                }
                $contrObject=new $controller;
                $result=$contrObject->$action($arr);
                if ($result!=0)
                {
                   break;
                }
           }
        }
    }
}
?>