<?php
return '<li id="'.$value["id"].'li"> <div class="newComment clearfix">
                <div class="avatar"><img src="/test/images/anonym2.png"></div>
                <div class="bodycomment">
                    <div class="author">'.$value["name"].'</div>
                    <div class="date">'.$value["date"].'</div>
                    <div class="comment">'.$value["comment"].'</div>
                    <div class="likes">
                        <div id="'.$value["id"].'" class="respond">Ответить</div>
                        <div id="l'.$value["id"].'" class="like"></div>
                        <span id="cl'.$value["id"].'" class="countLike">'.$value["likes"].'</span>
                        <div id="d'.$value["id"].'" class="dislike"></div>
                        <span id="cd'.$value["id"].'" class="countdisLike">'.$value["dislike"].'</span>
                        <div id="del'.$value["id"].'" class="delete">Удалить</div>
                    </div>
                </div>
            </div>
                <!--Block3-->
                <div id="r'.$value["id"].'" class="response clearfix">
                    <div class="avatar"><img src="/test/images/anonym2.png"></div>
                    <textarea id="f'.$value["id"].'" class="entryField" placeholder="Введите текст комментария"></textarea>
                    <button class="buttonComment" id="'.$value["id"].'But">Комментрировать</button>
                </div> </li>';
?>