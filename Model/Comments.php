<?php
class Comments{
    public function __construct()
    {
       
    }
    static public function InsertComment($user_id,$com,$parent_id,$date,$likes=0,$dislike=0)//запись комментариев в базу данных
    {
        $com=htmlspecialchars($com);
        $com=mysql_escape_string($com);
        DB::getConnection();
        mysql_query("INSERT INTO comments(user_id,parent_id,comment,date,likes,dislike) VALUES('$user_id','$parent_id','$com','$date','$likes','$dislike')");
        $result=mysql_query('SELECT *,(SELECT COUNT(id) FROM comments) AS count FROM comments LEFT JOIN users ON users.user_id=comments.user_id ORDER BY id DESC LIMIT 1');
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        mysql_free_result($result);
        mysql_close();
        return $row;
        
    }
    static public function ShowComments()//вывод всех комментарие
    {
        DB::getConnection();
        $query = 'SELECT * FROM comments LEFT JOIN users ON comments.user_id=users.user_id ';
        $result = mysql_query($query) or die('Запрос не удался:'.mysql_error());
        $Comments=array();
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $Comments[$row["parent_id"]][]=$row;
        }
        mysql_free_result($result);
        mysql_close(); 
        return  $Comments;
    }
     public static function  checkUserLike($comment_id,$user_id,$count)//проверяем ставил ли пользователь like
    {
        DB::getConnection();
        $result = mysql_query("SELECT comments.id,comments.user_id,check_like.checkLike FROM comments LEFT JOIN check_like ON check_like.comment_id=comments.id WHERE comments.id='$comment_id'");
         if( !(empty($user_id)))
         {
              while($row=mysql_fetch_array($result, MYSQL_ASSOC))
                   {
                        if($row['checkLike']==$user_id || $user_id==$row["user_id"] )
                        {
                            return false;
                        }
                   }
                    mysql_query("UPDATE comments SET likes='$count' WHERE id='$comment_id'");
                    mysql_query("INSERT INTO check_like(id,comment_id,checkLike) VALUES(NULL,'$comment_id','$user_id')");
                    return true;
         }
        else
        { 
            return false;
        }
         mysql_free_result($result);
        mysql_close(); 
    }
     public static function  checkUserDislike($comment_id,$user_id,$count)//проверяем ставил ли пользователь dislike
    {
        DB::getConnection();
        $result = mysql_query("SELECT comments.id,comments.user_id,check_like.checkDislike FROM comments LEFT JOIN check_like ON check_like.comment_id=comments.id WHERE comments.id='$comment_id'");
         if( !(empty($user_id)))
         {
              while($row=mysql_fetch_array($result, MYSQL_ASSOC))
                   {
                        if($row['checkDislike']==$user_id || $user_id==$row["user_id"] )
                        {
                            return false;
                        }
                   }
                    mysql_query("UPDATE comments SET dislike='$count' WHERE id='$comment_id'");
                    mysql_query("INSERT INTO check_like(id,comment_id,checkDislike) VALUES(NULL,'$comment_id','$user_id')");
                    return true;
         }
        else
        { 
            return false;
        }
         mysql_free_result($result);
        mysql_close(); 
     }
    public static function  deleteComment($comment_id,$user_id)
    {
        DB::getConnection();
        $result = mysql_query("SELECT id,user_id FROM comments WHERE id='$comment_id'");
         if( !(empty($user_id)))
         {
              $row=mysql_fetch_array($result, MYSQL_ASSOC);
                if($user_id==$row["user_id"] )
                    {
                        mysql_query("DELETE c,ch FROM comments c LEFT JOIN check_like ch ON c.id=ch.comment_id WHERE c.id='$comment_id'");
                        mysql_query("DELETE c,ch FROM comments c LEFT JOIN check_like ch ON c.id=ch.comment_id WHERE c.parent_id='$comment_id'");
                        return $row;
                    }
               else{
                   return false;
               }
         }
        else
        { 
            return false;
        }
        mysql_free_result($result);
        mysql_close(); 
     }
    
}
?>