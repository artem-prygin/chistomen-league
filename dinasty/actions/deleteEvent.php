<?php
session_start();
require_once 'db.php';

if ($_POST['id']) {
    $id = $_POST['id'];
    $userId = $_SESSION['userId'];
    $query = $connect->query("DELETE FROM events WHERE `id`='$id' AND `user_id`='$userId'");
}