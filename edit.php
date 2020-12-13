<head>
    <title>Изменение личных данных</title>
</head>

<body>
    <h2>Изменение личных данных</h2>
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
    <form action="update_user.php" method="post" enctype="multipart/form-data">

        <p><label>Имя:<br></label><input name="first_name" value="$first_name" type="text" size="30" maxlength="30"></p>
        <p><label>Фамилия:<br></label><input name="sur_name" value="$sur_name" type="text" size="30" maxlength="30"></p>
        <p><label>Отчество:<br></label><input name="pater_name" value="$pater_name" type="text" size="30" maxlength="30"></p>
        <p><label>Адрес электронной почты:<br></label><input name="email" value="$email" type="text" size="30" maxlength="30">
        </p>
        Текущий аватар:<br>
            <img alt='$login' src='$avatar'> <br>
            <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
            <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
        <p> <label>Выберите аватар. Изображение должно быть формата jpg, gif или png:<br></label>
            <input type="file" name="fupload">
        </p>

        <p>
            <input type="submit" name="submit" value="Изменить">
        (<a href='personal_account.php'>отмена</a>)<br>
        </p>
    </form>
    USERDATA;
    }
    ?>
</body>

</html>