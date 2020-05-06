<?php
session_start();
require_once 'db.php';
if ($_GET['id']) {
    $id = $_GET['id'];

    $event = $connect->query("SELECT * FROM events WHERE id='$id'");
    $event = $event->fetch(PDO::FETCH_ASSOC);


} ?>

<h2>Редактирование события</h2>
<input class="event-id" type="hidden" name="id" value="<?=$event['id']?>">
<div class="input-newEvent">
    <input class="input-name" type="text" name="event-title" required="" placeholder="Название события" value="<?=$event['title']?>">
</div>
<div class="input-newEvent">
    <input class="input-mail" type="text" name="event-place" required="" placeholder="Адрес события" value="<?=$event['place']?>">
</div>
<div class="input-newEvent">
    <input class="input-name input-dateNew" type="text" name="event-date" required="" placeholder="Дата в формате ГГГГ-ММ-ДД" value="<?=$event['time']?>">
</div>
<div class="input-newEvent">
    <textarea name="event-descr" required="" placeholder="Описание события" rows="3"><?=$event['descr']?></textarea>
</div>
<button class="button button-event button-form__reg" type="submit">РЕДАКТИРОВАТЬ СОБЫТИЕ</button>

<script>
    inputDateNew = $('.input-dateNew');
    for (let i=0; i<inputDateNew.length; i++) {
        inputDateNew[i].addEventListener('input', function () {

            this.value = this.value.replace(/\D/g, '');
            if (this.value.substr(0, 1) != 1 && this.value.substr(0, 1) != 2) {
                this.value = '';
            }

            if (this.value.length > 7) {
                if (this.value.substr(6, 2) > 31 || this.value.substr(6, 2) === '00') {
                    alert("Такого дня не существует");
                    this.value = this.value.substr(0, 4) + '-' + this.value.substr(4, 2) + '-' + '01';
                } else {
                    this.value = this.value.substr(0, 4) + '-' + this.value.substr(4, 2) + '-' + this.value.substr(6, 2);
                }
            } else if (this.value.length > 6) {
                if (this.value.substr(4, 2) > 12 || this.value.substr(4, 2) === '00') {
                    alert("Такого месяца не существует");
                    this.value = this.value.substr(0, 4) + '-' + '01' + '-';
                } else {
                    this.value = this.value.substr(0, 4) + '-' + this.value.substr(4, 2) + '-' + this.value.substr(6, 2);
                }
            } else if (this.value.length > 4) {
                if (this.value[this.value.length - 1] === '-') {
                    this.value = this.value.substr(0, 4);
                } else {
                    this.value = this.value.substr(0, 4) + '-' + this.value.substr(4, 2);
                }
            } else if (this.value.length === 4) {
                if (this.value > 2019) {
                    alert("Событие не может происходить в будущем");
                    this.value = 2019;
                }
            }
        });
    }
</script>