<?php
// Страница авторизации

# Функция для генерации случайной строки
function generateCode($length = 10)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    return $code;
}


# Соединямся с БД
include("bd.php");
mysqli_report(MYSQLI_REPORT_ALL);

if (isset($_POST['submit'])) {
    # Запрашиваем из БД запись, у которой логин равняется введенному
    $query = mysqli_query($db, "SELECT user_id, user_password FROM users WHERE user_login='" . mysqli_real_escape_string($db, $_POST['login']) . "' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    # Сравниваем пароли
    if ($data['user_password'] === md5(md5($_POST['password']))) {
        # Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if (!@$_POST['not_attach_ip']) {
            # Если пользователя выбрал привязку к IP
            # Переводим IP в строку
            if ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) {
                $insip = ", user_ip=INET_ATON('" . "127.0.0.1" . "')";
            } else
                $insip = ", user_ip=INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "')";
        }

        # Записываем в БД новый хеш авторизации и IP
        mysqli_query($db, "UPDATE users SET user_hash='" . $hash . "' " . $insip . " WHERE user_id='" . $data['user_id'] . "'");

        # Ставим куки
        setcookie("id", $data['user_id'], time() + 60 * 60 * 24 * 30);
        setcookie("hash", $hash, time() + 60 * 60 * 24 * 30);

        # Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: check.php");
        exit();
    } else {
        print "Вы ввели неправильный логин/пароль";
    }
}
?>


<html>

<head>
    <title>Главная страница</title>
</head>

<body>
    <h2>Главная страница</h2>

    <?php
    //print_r($_COOKIE);
    // Проверяем, залогинен ли пользователь
    if (empty($_COOKIE['hash']) or empty($_COOKIE['id'])) {
        print <<<LOGINFORM

     
        Вы вошли на сайт, как гость<br>
            <p>

                <a href="login.php">Войти</a>
                <br><a href="reg.php">Зарегистрироваться</a>
            </p>

     
        LOGINFORM;
        // если нет
        echo "";
    } else {
        include("bd.php");
        $querry = "SELECT user_login FROM users WHERE user_id='" . mysqli_real_escape_string($db, $_COOKIE['id']) . "'";
        if (mysqli_real_query($db, $querry)) {

            $result = mysqli_use_result($db);
            $myrow = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            $login = $myrow['user_login'];

            // Если не пусты, то мы выводим ссылку
            echo "Вы вошли на сайт, как " .  $login . "<br><a  href='personal_account.php'>Личнй кабинет</a><br>";
            echo  "(<a    href='exit.php'>выход</a>)<br>";
            //echo $_COOKIE['id'] . "<br>";
            //echo $_COOKIE['hash'] . "<br>";
        }
    }


    ?>
</body>

</html>