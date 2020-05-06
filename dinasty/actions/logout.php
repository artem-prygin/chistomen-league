<?php

session_start();
if (isset($_POST['logout'])) {
    unset ($_SESSION['userId']);
    header("Location: ../index.php");
}