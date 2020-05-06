<?php
session_start();
require_once 'db.php';
if ($_POST['event-title']) {
    $userId = $_SESSION['userId'];
    $title = trim(htmlspecialchars($_POST['event-title']));
    $place = trim(htmlspecialchars($_POST['event-place']));
    $date = trim(htmlspecialchars($_POST['event-date']));
    $descr = trim(htmlspecialchars($_POST['event-descr']));

    $query = $connect->prepare("INSERT INTO events (title, descr, place, time, user_id, img) VALUES (:title, :descr, :place, :time, :user_id, :img)");
    $arr = ["title" => $title, "descr" => $descr, "place" => $place, "time" => $date, "user_id" => $userId, "img" => $fileName];
    $query->execute($arr);

    $events = $connect->query("SELECT * FROM events WHERE user_id='$userId'");
    $events = $events->fetchAll(PDO::FETCH_ASSOC);

    foreach ($events as $event) { ?>
        <div class="event-item" data-id="<?= $event['id']?>">
            <div class="event-item-block-img" style="background-image:
                    url(<?= $event['img'] ? "img/user{$event['user_id']}/event{$event['id']}/{$event['img']}" : "img/lk/noimage.jpg" ?>);">
                <div class="example-3">
                    <div class="form-group">
                        <form action="actions/eventImg.php" class="eventImg" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="event-id" value="<?=$event['id']?>">
                            <input class="newImage" type="file" name="file2" required>
                            <input class="example-3__submit" name="event-img" type="submit">
                        </form>
                    </div>
                </div>
            </div>

            <div class="event-item-block-content">
                <div class="event-item-block-top">
                    <div class="event-item-block-top__name"><?=$event['title']?></div>
                    <div class="event-item-block-top__time">
                        <span class="doc_time"></span>
                    </div>
                    <div class="event-item-block-top__time event-item-block-top__timePass">
                        <span class="pass_time" data-time="<?=$event['id']?>"></span>
                        <script>count('<?=$event['time']?>','<?=$event['id']?>')</script>
                    </div>
                    <a href="#" class="updateEventWrap">
                        <span data-id="<?=$event['id']?>" class="mdi mdi-settings updateEvent"></span>
                    </a>
                    <a href="" data-id="<?=$event['id']?>" class="deleteEventWrap">
                        <img class="deleteEvent" data-id="<?=$event['id']?>" src="img/icons/trash.png" alt="delete">
                    </a>
                </div>

                <div class="event-item-block-bottom">
                    <div class="event-item-block-bottom__no-btn">
                        <div class="event-item-block-bottom__point">
                            <div class="event-item-block-bottom__point-title">Место</div>
                            <div class="event-item-block-bottom__point-loc"><?=$event['place']?></div>
                        </div>
                        <div class="event-item-block-bottom__date">
                            <div class="event-item-block-bottom__date-title">Время</div>
                            <div class="event-item-block-bottom__date-time"><?=$event['time']?></div>
                        </div>
                    </div>

                    <div class="event-item-block-bottom__btn">
                        <button class="event-item-button-more" data-id="<?= $event['id']?>">Подробнее ></button>
                    </div>
                </div>

                <div class="event-item-block-bottom__descr hide" data-more="<?= $event['id']?>">
                    Описание события: <?=$event['descr']?>
                </div>
            </div>
        </div>
<? }}
