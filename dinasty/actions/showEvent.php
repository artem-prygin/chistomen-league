<?php
session_start();
require_once 'db.php';
if ($_GET['id']) {
    $id = $_GET['id'];

    $event = $connect->query("SELECT * FROM events WHERE id='$id'");
    $event = $event->fetch(PDO::FETCH_ASSOC);


} ?>

<h2>Просмотр события</h2>
<input class="event-id" type="hidden" name="id" value="<?=$event['id']?>">

<div class="input-newEvent">
    <input class="input-name" type="text" name="event-title" required="" placeholder="Название события" value="<?=$event['title']?>" readonly>
</div>
<div class="input-newEvent">
    <input class="input-mail" type="text" name="event-place" required="" placeholder="Адрес события" value="<?=$event['place']?>" readonly>
</div>
<div class="input-newEvent">
    <input class="input-name" type="date" name="event-date" required="" placeholder="Дата события" value="<?=$event['time']?>" readonly>
</div>
<div class="input-newEvent">
    <textarea name="event-descr" required="" placeholder="Описание события" rows="3" readonly><?=$event['descr']?></textarea>
</div>
<div class="event-item-block-img event-img" style="background-image:
    url(<?= $event['img'] ? "img/lk/{$event['userId']}/{$event['img']}" : "img/lk/noimage.jpg" ?>);">
</div>
