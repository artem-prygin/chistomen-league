<?php

require_once 'db.php';
require_once 'link.php';

if (!isset($_POST['username'])) {
    header("Location: ../index.php");
}

$username = trim(htmlspecialchars($_POST['name']));
$pass = htmlspecialchars($_POST['pass']);
$pass = hash('md5', $pass);
$email = trim(htmlspecialchars($_POST['email']));
$city = trim(htmlspecialchars($_POST['city']));
$country = trim(htmlspecialchars($_POST['country']));
$auth = hash('md5', date('YmdHis'));

$query = $connect->prepare("INSERT INTO users (username, pass, email, city, country, `auth_key`) VALUES (:username, :pass, :email, :city, :country, :auth)");
$arr = ["username" => $username, "pass" => $pass, "email" => $email, "city" => $city, "country" => $country, "auth" => $auth];
$query->execute($arr);

// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";

$message = "<a href='$link/?auth=" . $auth . "'>Перейдите по ссылке</a>";

mail($email, "Dinasty. Подтвердите почту", $message, $headers);