<?php
session_start();
?>
<html>

<head>
    <title>Главная страница</title>
</head>

<body>
    <h2>Главная страница</h2>
    <form action="authorize.php" method="post">
        <p>
            <label>Ваш логин:<br></label>
            <input name="login" type="text" size="15" maxlength="15">
        </p>
        <p>
            <label>Ваш пароль:<br></label>
            <input name="password" type="password" size="15" maxlength="15">
        </p>
        <p>
            <input type="submit" name="submit" value="Войти">
            <br><a href="reg.php">Зарегистрироваться</a>
        </p>
    </form>
    <br>
    <?php
    // Проверяем, залогинен ли пользователь
    if (empty($_SESSION['login']) or empty($_SESSION['id'])) {
        // если нет
        echo "Вы вошли на сайт, как гость<br><a href='#'>Эта ссылка  доступна только зарегистрированным пользователям</a>";
    } else {
        // Если не пусты, то мы выводим ссылку
        echo "Вы вошли на сайт, как " . $_SESSION['login'] . "<br><a  href='http://tvpavlovsk.sk6.ru/'>Эта ссылка доступна только  зарегистрированным пользователям</a>";
    }

    ?>
</body>

</html>