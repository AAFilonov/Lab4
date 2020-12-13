<?php

if (isset($_POST['new_password'])) {
    $new_password = $_POST['new_password'];
    if ($new_password == '') {
        unset($new_password);
    }
}
if (isset($_POST['old_password'])) {
    $old_password = $_POST['old_password'];
    if ($old_password == '') {
        unset($old_password);
    }
}

if (isset($new_password) and isset($old_password)) //если данные введены
{

    $new_password = md5(md5(trim($new_password)));
    $old_password = md5(md5(trim($old_password)));
    include("bd.php");
    # Запрашиваем из БД запись, у которой id равен id  из кука
    $query = mysqli_query($db, "SELECT user_password, user_password FROM users WHERE user_id='" . $_COOKIE["id"] . "' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    //print_r($data);
    if ($data['user_password'] ===   $old_password) {
        mysqli_query($db, "UPDATE users SET user_password='" .  $new_password . " WHERE user_id='" . $_COOKIE["id"] . "'");
    } else {
        exit("Введенный пароль не соотвественн существующему!");
    }

    //print_r($myrow);


    echo    "<html>
    <head>
    </head>
    <body>
    Пароль успешно изменен! <br><br>
    <a href='index.php'>На главную</a>
    <a href='personal_account.php'>Личный кабинет</a>
    </body>
    </html>";
} else { //если    данные еще не введены

    echo '

    <html>

    <head>
        <title>Смена пароля</title>
    
    </head>
    
    <body>
        <h2>Смена пароля</h2>
        <form method="POST">
            <label>Введите текущий пароль:<br></label>
            <input name="old_password" type="password" size="15" maxlength="15"><br>
            <label>Введите новый пароль:<br></label>
            <input name="new_password" type="password" size="15" maxlength="15"><br><br>
            <input name="submit" type="submit" value="Отправить"><br>
            <a href="send_pass.php">Забыли пароль?</a><br>
            
        </form>
    </body>
    
    </html>';
}