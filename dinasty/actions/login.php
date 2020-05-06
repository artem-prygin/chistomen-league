<?php
session_start();
require_once 'db.php';

if (isset($_POST['userEmail'])) {
    $email = $_POST['userEmail'];
    $pass = $_POST['userPass'];
    $pass = hash('md5', $_POST['userPass']);

    $query = $connect->query("SELECT * FROM users WHERE `email`='$email' AND pass='$pass'");
    $query = $query->fetch(PDO::FETCH_ASSOC);
    if ($query && $query['validation']==1) {
        $_SESSION['userId'] = $query['id'];
        $array = [
            "success" => 1,
        ];
        echo json_encode($array);
    } else if ($query && $query['validation']==0) {
        $array = [
            "message" => 'Вы не подтвердили свою почту',
        ];
        echo json_encode($array);
    } else {
        $array = [
            "error" => 1,
            "message" => 'Неверный пароль'
        ];
        echo json_encode($array);
    }
}