<?php
require_once 'db.php';

if (strlen($_POST['findEmail'])>0) {
    $findEmail = $_POST['findEmail'];
    $query = $connect->query("SELECT email FROM users WHERE email='$findEmail'");
    $query = $query->fetch();
    if ($query) {
        echo "<span style='color: green'>Мы нашли ваш email :)</span>";
    } else {
        echo "<span style='color: red'>Такого email нет в базе :(</span>";
    }
}