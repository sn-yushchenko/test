<?php
class User{
    public function __construct()
    {
        
    }
    public static function getCookie()//метод получения безопасных  Cookie
    {
        $cookie="";
        $str="abcdefgijclm1234567890";
        
        for($i=0;$i<=10;$i++)
        {
            $cookie.=substr($str,rand(0,strlen($str)),1);
        }
        return $cookie;
    }
    public static function checkEmail($email)//проверка валидности email
    {
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL) === false))
        {
           return true; 
        }
        else 
        {
            return false;
        }
    }
    public static function checkName($name)//проверка валидности имени
    {
        if (strlen($name)>2)
        {
           return true; 
        }
        else 
        {
            return false;
        }
    }
    public static function checkPassword($password)//проверка валидности пароля
    {
        if (strlen($password)>6)
        {
           return true; 
        }
        else 
        {
            return false;
        }
    }
    public static function checkEmailExist($email)// проверяем нет ли пользователя с введеннім именем
    {
         DB::getConnection();
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysql_query($query) or die('Запрос не удался:'.mysql_error());
        if(mysql_fetch_array($result, MYSQL_ASSOC)) 
        {
            return true;
        }
        else
        { 
            return false;
        }
        mysql_free_result($result);
        mysql_close(); 
    }
    public static function register($email,$password,$name)//запись пользовательских данніх в БД
    {
        $email=htmlspecialchars($email);
        $email=mysql_escape_string($email);
        $password=htmlspecialchars($password);
        $password=mysql_escape_string($password);
        $name=htmlspecialchars($name);
        $name=mysql_escape_string($name);
        DB::getConnection();
        $password=md5($password);
        mysql_query("INSERT INTO users (user_id,name,email,password,cookie) VALUES(NULL,'$name','$email','$password')");
        mysql_close();
        return true;
    }
    public static function autorization($email,$password)//проверка авторизованных данных
    {
        DB::getConnection();
        $email=htmlspecialchars($email);
        $email=mysql_escape_string($email);
        $cookie=User::getCookie();
        $password=md5($password);
        $result=mysql_query("SELECT * FROM users WHERE email='$email'");
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if($result && $row["password"]==$password)
        {
            mysql_query("UPDATE users SET cookie='$cookie' WHERE email='$email'");
            setcookie("Cookie",$cookie,time()+3600);
            return array("name"=>$row["name"],"user_id"=>$row["user_id"]);                
        }
        else
        {
            return false;
        }
        mysql_free_result($result);
        mysql_close();
    }
     public static function usersCookie($cookie)//проверка авторизованных данных
    {
        DB::getConnection();
        $result=mysql_query("SELECT user_id, name FROM users WHERE cookie='$cookie'");
         $row=mysql_fetch_array($result, MYSQL_ASSOC);
        mysql_free_result($result);
        mysql_close();
        return $row;
    }
   
}
?>