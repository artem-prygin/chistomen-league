<?php
session_start();
require_once 'db.php';

if ($_POST['id']) {

    $id = $_POST['id'];
    $time = $_POST['event-date'];
    $title = $_POST['event-title'];
    $descr = $_POST['event-descr'];
    $place = $_POST['event-place'];

    $query = $connect->prepare("UPDATE events SET descr=:descr, title=:title, time=:time, place=:place WHERE id='$id'");
    $arr = ["title" => $title, "descr" => $descr, "time" => $time, "place" => $place];
    $query->execute($arr);
}