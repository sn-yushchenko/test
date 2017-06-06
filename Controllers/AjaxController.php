 <?php
class AjaxController{
     public function __construct()
    {
                
    }
    public function actionAdd()//функция добавления комментариев
    {
        $comment=$_POST['comment'];
        $user_id=$_POST['user_id'];
        $parent_id=$_POST['parent_id'];
        date_default_timezone_set('UTC');
        $date=date("Y.d.m",time());
        $value=Comments::InsertComment($user_id,$comment,$parent_id,$date);
        sleep(1);
        echo require_once(ROOT."/View/newComment.php");
        return true;               
    }
//        public function actionAutorization()//авторизация польователя
//    {
//        $errors=array();
//        $name=$_POST['name'];
//        $email=$_POST['email'];
//        if(!(User::checkEmail($email)))
//        {
//            $errors[]="Email не является правильным E-Mail адресом!";
//        }
//        if (!(User::checkName($name)))
//        {
//            $errors[]="Ошибка ввода имени!";
//        }
//        if(!empty($errors))
//        { 
//            echo json_encode($errors);
//            return true;
//        }      
//    } 
    public function actionLike()// обработка оцениявания комментариев
    {
        $comment_id=$_POST["comment_id"];
        $user_id=$_POST["user_id"];
        $cLike=$_POST["countLike"]+1;
        $check=Comments::checkUserLike($comment_id,$user_id,$cLike);
        if($check)
         {
              echo $cLike;       
         } 
        else
        {
             echo $_POST["countLike"];
        }
        return true;  
    }
    public function actionDisLike()// обработка оцениявания комментариев
    {
        $comment_id=$_POST["comment_id"];
        $user_id=$_POST["user_id"];
        $cDlike=$_POST["countDislike"]+1;
        if(Comments::checkUserDislike($comment_id,$user_id, $cDlike))
        {   
            echo $cDlike;
        }
        else
        {
            echo $_POST["countDislike"];
        }
        
        return true;
    }  
    public function actionDelete()
    {
        $comment_id=$_POST["comment_id"];
        $user_id=$_POST["user_id"];
        if(Comments::deleteComment($comment_id,$user_id))
        {   
            echo true;
        }
        else
        {
            echo false;
        }
        
        return true;
    }    
}
?>