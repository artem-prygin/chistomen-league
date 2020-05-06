<?php

session_start();

if (!$_SESSION['userId']) {
    header("Location: index.php");
}

$id = $_SESSION['userId'];

require_once 'db.php';

//die(var_dump($_FILES));

if (isset($_POST['event-img'])) {

    $fileName = $_FILES['file2']['name'];
    $fileTmpName = $_FILES['file2']['tmp_name'];
    $fileType = $_FILES['file2']['type'];
    $fileError = $_FILES['file2']['error'];
    $fileSize = $_FILES['file2']['size'];
    $eventId = $_POST['event-id'];

    $fileExtension = strtolower(end(explode('.', $fileName)));
    $fileName = explode('.', $fileName)[0];
    $fileName = preg_replace('/[0-9];/', '', $fileName);
    $fileName = preg_replace('/\s/', '', $fileName);
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExtension, $allowedExtensions)) {
        if ($fileSize < 5000000) {
            if ($fileError === 0) {
                $date = date('YmdHis');
                $fileName = "$fileName-$date.$fileExtension";
                $connect->query("UPDATE events SET img='$fileName' WHERE id='$eventId'");
                if (!is_dir("../img/user$id")) {
                    mkdir("../img/user$id");
                }
                if (!is_dir("../img/user$id/event$eventId")) {
                    mkdir("../img/user$id/event$eventId");
                }
                $fileDestination = "../img/user$id/event$eventId/$fileName";
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: ../lk.php");
            } else {
                echo 'Что-то пошло не так';
            }
        } else {
            echo 'Слишком большой размер файла';
        }
    } else {
        echo 'Неверный тип файла';
    }
}