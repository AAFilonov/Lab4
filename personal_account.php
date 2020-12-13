<html>

<head>
    <title>Личный кабинет</title>
</head>

<body>
    <h2>Личный кабинет</h2>
    <?php

    include("bd.php");
    $querry = "SELECT * FROM users WHERE user_id='" . mysqli_real_escape_string($db, $_COOKIE['id']) . "'";
    if (mysqli_real_query($db, $querry)) {

        $result = mysqli_use_result($db);
        $myrow = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        //print_r($myrow);
        $login = $myrow['user_login'];
        $first_name = $myrow['first_name'];
        $sur_name = $myrow['sur_name'];
        $pater_name = $myrow['pater_name'];
        $avatar = $myrow['avatar'];
        $email = $myrow['email'];

        print <<<USERDATA
        <!-- Между оператором     "print <<<HERE" выводится html код с нужными    переменными из php -->
                    Вы    вошли на сайт, как $login    (<a    href='exit.php'>выход</a>)<br>
                    
                    <!-- выше ссылка на выход из аккаунта -->   
                    Ваши личные данные:<br>
                    Ваш   аватар:<br>
                    <img    alt='[image_load_error]' src='$avatar'> <br>
                 
                    Адрес электронной почты: $email<br>                             
                    Имя: $first_name<br>
                    Фамилия: $sur_name<br>
        USERDATA;
        if (!empty($pater_name))  echo "Имя: " . $pater_name . "<br>";

        echo " <a href='edit.php'>Нажмите чтобы изменить личные данные</a><br>";
        echo " <a href='change_pass.php'>Нажмите чтобы изменить пароль</a><br>";
        echo "<br><a  href='index.php'>На главную</a>";
    } else {
        exit("Неизветная ошибка");
    }
    ?>

</body>

</html>