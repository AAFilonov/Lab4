<?php
// Скрипт проверки

# Соединямся с БД
include("bd.php");


if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    $query = mysqli_query($db, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '" . intval($_COOKIE['id']) . "'LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    if ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR'])
        $check_adr = "127.0.0.1";
    else
        $check_adr = $_SERVER['REMOTE_ADDR'];

    if (($userdata['user_hash'] !== $_COOKIE['hash']) or
        ($userdata['user_id'] !== $_COOKIE['id']) or
        (($userdata['user_ip'] !==  $check_adr) and
            ($userdata['user_ip'] !== "0"))
    ) {
        setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
        echo "что-то не получилось";
    } else {
        echo "Привет, " . $userdata['user_login'] . ". Всё работает!";
        echo "<br><a  href='index.php'>На главную</a>";
        echo "<br><a  href='index.php'>Личный кабинет</a>";
    }
} else {
    echo "Включите куки";
}