<?php
require_once 'db.php';

if (strlen($_POST['checkEmail'])>0) {
    $checkEmail = $_POST['checkEmail'];
    $query = $connect->query("SELECT email FROM users WHERE email='$checkEmail'");
    $query = $query->fetch();
    if ($query) {
        echo 'Данный email занят';
    } else {
        echo "<script>newEmail = true </script>";
        echo "<span style='color: green'>Email свободен</span>";
    }
}