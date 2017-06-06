<!DOCTYPE html>
<html>

<head>
    <title>Регистрация</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/test/style/registration.css">
</head>

<body>
    <div class="registration">
        <?php if($result): ?>
        <p>Вы зарегистрированы! Теперь выможете оставлять свои комментарии!</p>
        <?php else: ?>
         <?php if(!(empty($errors))): ?>
        <div class="err">
        <ul>
            <?php foreach($errors as $error): ?>
            <li>- <?php echo $error; ?></li>
            <?php endforeach; ?>
       </ul>
       </div>
    <?php endif; ?>
        <div id="test">Test</div>
        <form action="#" method="post">
            <input type="text" placeholder="Логин" name="name" value="<?php echo $name ?>">
            </br>
            <input type="text" placeholder="e-mail" name="email" value="<?php echo $email ?>">
            </br>
            <input type="password" placeholder="Пароль" name="password" value="<?php echo $password ?>">
            </br>
            <input type="submit" value="Зарегистрироватья" name="submit" id="sub">
        </form> 
    <?php endif ?>
</div>
</body>

</html>