<?php

require_once 'db.php';

if (!isset($_POST['username'])) {
    header("Location: ../lk.php");
}

$username = trim(htmlspecialchars($_POST['support-username']));
$phone = trim(htmlspecialchars($_POST['support-phone']));
$email = trim(htmlspecialchars($_POST['support-email']));
$descr = trim(htmlspecialchars($_POST['support-descr']));

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";

$message = "
<div>$username оставил заявку</div>
<div>Телефон: $phone</div>
<div>Email: $email</div>
<div>Суть проблемы: $descr</div>
";

$message2 = "
<div>Скоро свяжемся с вами! Спасибо :)</div>
<div>Суть вашей проблемы: \"$descr\"</div>
";

mail('aprygin@mail.ru', "Новая заявка на поддержку", $message, $headers);
mail($email, "Мы получили вашу заявку", $message2, $headers);