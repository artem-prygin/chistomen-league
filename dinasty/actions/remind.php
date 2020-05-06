<?php

if (!isset($_POST['userEmail-remind'])) {
    header("Location: index.php");
}

require_once 'db.php';
require_once 'link.php';
$email = $_POST['userEmail-remind'];
$remindPass = hash('md5', date('mYmdHis'));
$query = $connect->query("UPDATE users SET remindPass='$remindPass' WHERE email='$email'");

// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";

$message = "<a href='$link/?passAuth=" . $remindPass . "'>Перейдите по ссылке, чтобы задать новый пароль</a>";

mail($email, "Dinasty. Сброс пароля", $message, $headers);