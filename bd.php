<?php
$db = mysqli_connect("127.0.0.1", "root", "", "web_db");

/* проверка соединения */
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}
mysqli_report(MYSQLI_REPORT_ALL);