<?php
if (isset($_POST['submit'])) {
    $err = array();
    try {

        $login = $_POST['login'];
        $password = md5(md5(trim($_POST['password'])));

        if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
        {
            exit("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
        }

        //если логин и пароль введены, то обрабатываем их
        $login = stripslashes($login);
        $login = htmlspecialchars($login);
        $password = stripslashes($password);
        $password = htmlspecialchars($password);

        # проверям логин
        if (!preg_match("/^[a-zA-Z0-9]+$/", $login)) {
            throw new Exception("Логин может состоять только из букв английского алфавита и цифр");
        }
        if (strlen($login) < 3 or strlen($login) > 30) {
            throw new Exception("Логин должен быть не меньше 3-х символов и не больше 30");
        }

        // подключаемся к базе
        include("bd.php");
        mysqli_report(MYSQLI_REPORT_ALL);
        # проверяем, не существует ли пользователя с таким именем


        $querry = "SELECT COUNT(*) FROM users WHERE user_login='" . mysqli_real_escape_string($db, $login) . "'";

        if (mysqli_real_query($db, $querry) === false) {
            throw new Exception("Неизвестная ошибка базы");
        } else {
            $result = mysqli_use_result($db);
            $row = mysqli_fetch_row($result);
            mysqli_free_result($result);
            if ($row[0] != 0)
                throw new Exception("Пользователь с таким логином уже существует в базе данных");
        }

        if (mysqli_real_query($db, "INSERT INTO users (user_login,user_password) VALUES('$login','$password')")) {
            header("Location: login.php");
            exit();
        } else {
            throw new Exception("Не удалось добавить пользователя");
        }
    } catch (Exception $e) {
        echo "<b>При регистрации произошли следующие ошибки:</b><br>";
        echo  $e->getMessage() . "<br>";
    }
}