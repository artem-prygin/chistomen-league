<?php

session_start();
require_once 'db.php';

if (isset($_POST['descr'])) {
    $descr = trim(htmlspecialchars($_POST['descr']));
    $username = trim(htmlspecialchars($_POST['username']));
    $date = trim(htmlspecialchars($_POST['date']));
    $country = trim(htmlspecialchars($_POST['country']));
    $id = $_SESSION['userId'];

    $query = $connect->prepare("UPDATE users SET descr=:descr, username=:username, date=:date, country=:country WHERE id='$id'");
    $arr = ["username" => $username, "descr" => $descr, "date" => $date, "country" => $country];
    $query->execute($arr);

    echo "Информация успешно обновлена";
}