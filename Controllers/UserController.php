<?php
class UserController{
    public function __construct()
    {
        
    }
    public function actionRegister()//регистрация пользователя
    {
        $name="";
        $email="";
        $password="";
        $result=false;
        if(isset($_POST['submit']))
        {
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $errors=false;
            if(!User::checkName($name))
            {
                 $errors[]="Имя должно содержать не менее 2-х символов!";
            }
            if(!User::checkEmail($email))
            {
                $errors[]="Email не является правильным E-Mail адресом!";
            }
            if(!User::checkPassword($password))
            {
                $errors[]="Пароль не соответствует системным требования!";
            }
            if(User::checkEmailExist($email))
            {
                 $errors[]="Пользователь с данным email уже зарегистрирован!";
            }
            if($errors==false)
            {
               $result=User::register($email,$password,$name);
            }
        }

        require_once(ROOT.'/View/registr.php');  
        return true;       
    }
    public function actionAutorization()//авторизация пользователя
    {
        $email=$_POST['email'];
        $password=$_POST['password'];
        $arr=User::autorization($email,$password);
        if($arr)
        {
            echo json_encode($arr);
        }
        else
        {
            echo 1;
        }
        return true;       
    }
}
?>