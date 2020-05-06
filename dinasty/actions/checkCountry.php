<?php
require_once 'db.php';

if (strlen($_POST['checkCountry'])>0) {
    $checkCountry = $_POST['checkCountry'];
    $query = $connect->query("SELECT `title_ru` FROM countries WHERE `title_ru`='$checkCountry'");
    $query = $query->fetch();
    if (!$query) {
        echo 'Такой страны не существует :(';
    } else {
        echo "<script>country = true </script>";
        echo "<span style='color: green'>{$query['title_ru']} - прекрасная страна :)</span>";
    }
}