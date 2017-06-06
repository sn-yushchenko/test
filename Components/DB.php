<?php
class DB{
    public static function getConnection()
    {
        /*----Подключение базы данных-----*/
        
        $parPath=ROOT."/config/SQL.php";
        $params=include($parPath);
        error_reporting(0);
        $link = mysql_connect($params['host'], $params['user'], $params['password']) or die('Не удалось соединиться: '.mysql_error());
        mysql_select_db($params['name_db']) or die('Не удалось выбрать базу данных');
    }
}
?>