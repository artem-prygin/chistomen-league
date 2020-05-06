<?php

session_start();

if (!$_SESSION['userId']) {
    header("Location: index.php");
}

require_once 'db.php';
$id = $_SESSION['userId'];

if (isset($_POST['avatar'])) {

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];
    $fileError = $_FILES['file']['error'];
    $fileSize = $_FILES['file']['size'];

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
                $connect->query("UPDATE users SET img='$fileName' WHERE id='$id'");
                if (!is_dir("../img/user$id")) {
                    mkdir("../img/user$id");
                }
                $fileDestination = "../img/user$id/$fileName";
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