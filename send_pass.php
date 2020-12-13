<?php
if (isset($_POST['login'])) {
    $login = $_POST['login'];
    if ($login == '') {
        unset($login);
    }
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if ($email == '') {
        unset($email);
    }
}
if (isset($login) and isset($email)) { //если существуют необходимые переменные  

    include("bd.php"); // файл    bd.php должен быть в той же папке, что и все остальные, если это не так, то    просто измените путь 
    $query = "SELECT user_id FROM users WHERE user_login='$login' AND    email='$email'";

    $result  = mysqli_query($db, $query);
    $myrow  = mysqli_fetch_assoc($result);
    //print_r($myrow);
    if (empty($myrow['user_id']) or $myrow['user_id'] == '') {
        exit("Пользователя с таким e-mail адресом не обнаружено<br> <a href='index.php'>Главная страница</a>");
    }
    //если пользователь с таким логином и е-мейлом найден,    то необходимо сгенерировать для него случайный пароль, обновить его в базе и    отправить на е-мейл
    $datenow = date('YmdHis'); //извлекаем    дату 
    $new_password = md5($datenow); // шифруем    дату
    $new_password = substr($new_password,    2, 6); //извлекаем из шифра 6 символов начиная    со второго. Это и будет наш случайный пароль. Далее запишем его в базу,    зашифровав точно так же, как и обычно.
    $new_password_sh =    md5(md5($new_password)) . "b3p6f"; //зашифровали 
    $q = "UPDATE users SET    user_password='$new_password_sh' WHERE user_login='$login'";
    mysqli_query($db, $q); // обновили в базе 

    //формируем сообщение
    $message = "Здравствуйте,    " . $login . "! Мы сгененриоровали для Вас пароль, теперь Вы сможете войти на сайт, используя его. После входа желательно его сменить.    Пароль:\n" . $new_password; //текст сообщения
    //mail($email,    "Восстановление пароля", $message, "Content-type:text/plane;    Charset=windows-1251\r\n"); //отправляем сообщение 

    echo    "<html><head></head><body>На Ваш e-mail отправлено письмо с паролем <br>(на самом деле нет, вот ваш пароль: $new_password)<br><a href='index.php'>На главную</a></body></html>"; //перенаправляем    пользователя
} else { //если    данные еще не введены
    echo '

            <html>
            <head>
            <title>Забыли пароль?</title>
            </head>
            <body>
            <h2>Забыли пароль?</h2>
            <form action="#"    method="post">
            Введите Ваш логин:<br>    <input type="text"    name="login"><br><br>
            Введите Ваш    E-mail: <br><input type="text"    name="email"><br><br>
            <input type="submit"    name="submit" value="Отправить">
            </form>
            </body>
            </html>';
}