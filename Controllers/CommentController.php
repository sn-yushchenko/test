<?php
class CommentController{
     public function __construct()
    {
                
    }
    public function actionShow()//загрузка начальной страницы с комментариями
    {
        if(isset($_COOKIE["Cookie"]))
        {
            $user=User::usersCookie($_COOKIE["Cookie"]);
            $user_name=$user['name'];
            $user_id=$user['id'];
            $Comments=Comments::ShowComments();
            require_once(ROOT.'/View/index.php');
        }
        else
        {
            $user_name="Имя пользователя";
            $user_id="";
            $Comments=Comments::ShowComments();
            require_once(ROOT.'/View/index.php');
        }
          
        return true;
    }
}
?>