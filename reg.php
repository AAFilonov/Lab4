<html>

<head>
    <title>Регистрация</title>
</head>

<body>
    <h2>Регистрация</h2>
    <form action="save_user.php" method="post" enctype="multipart/form-data">

        <p>
            <label>Ваш логин:<br></label>
            <input name="login" type="text" size="15" maxlength="15">
        </p>
        <p>
            <label>Ваш пароль:<br></label>
            <input name="password" type="password" size="15" maxlength="15">
        </p>
        <p><label>Имя:<br></label><input name="first_name" type="text" size="30" maxlength="30"></p>
        <p><label>Фамилия:<br></label><input name="sur_name" type="text" size="30" maxlength="30"></p>
        <p><label>Отчество (при наличии):<br></label><input name="pater_name" type="text" size="30" maxlength="30"></p>
        <p><label>Адрес электронной почты:<br></label><input name="email" type="text" size="30" maxlength="30">
        </p>
        <p> <label>Выберите аватар. Изображение должно быть формата jpg, gif или png:<br></label>
            <input type="FILE" name="fupload">
        </p>

        <p>
            <input type="submit" name="submit" value="Зарегистрироваться">
        </p>
    </form>
</body>

</html>