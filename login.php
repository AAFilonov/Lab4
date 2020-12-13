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
        setcookie("id", $data['user_id'], time() + 60 * 60 * 24 * 30, "/");
        setcookie("hash", $hash, time() + 60 * 60 * 24 * 30, "/");

        # Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: check.php");
        exit();
    } else {
        print "Вы ввели неправильный логин/пароль";
    }
}
?>
<h2>Авторизация</h2>
<form method="POST">

    <label>Ваш логин:<br></label>
    <input name="login" type="text" size="15" maxlength="15"><br>
    <label>Ваш пароль:<br></label>
    <input name="password" type="password" size="15" maxlength="15"><br>
    Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br>

    <input name="submit" type="submit" value="Войти"><br>
    <a href="send_pass.php">Забыли пароль?</a><br>
</form>