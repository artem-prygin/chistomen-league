<?php

if (!isset($_POST['pass-new'])) {
    header("Location: index.php");
}

require_once 'db.php';
$passNew = $_POST['pass-new'];
$passNew = hash('md5', $passNew);
$auth = $_POST['auth'];
$connect->query("UPDATE users SET pass='$passNew' WHERE remindPass='$auth'");