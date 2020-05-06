<?
 session_start();

 if (!$_SESSION['userId']) {
     header("Location: index.php");
 }

$id = $_SESSION['userId'];

require_once 'actions/db.php';

require_once 'header.php';


    $query = $connect->query("SELECT * FROM users WHERE id='$id'");
    $data = $query->fetch();

    $events = $connect->query("SELECT * FROM events WHERE user_id='$id'");
    $events = $events->fetchAll(PDO::FETCH_ASSOC);

?>

<style>
    html, body, #map {
        width: 100%; height: 100%; padding: 0; margin: 0;
    }
    .map-wrap {
        margin-bottom: 30px;
        width: 100%;
        height: 400px;
    }
</style>


    <? require_once 'actions/lk-menu.php'?>

	<!-- main start -->
	<section class="main-lk">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="main-lk-block">
						<div class="main-lk-block__left order-1">
							<div class="main-lk-block__button">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- main end -->

	<!-- lk start -->
	<section class="lk">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="block-content__primary">
					<div class="lk-block__content-main">
						<div class="lk-block__left">
							<div class="lk-block__avatar" style="background: url('<?=$data['img'] ? "img/user{$data['id']}/{$data['img']}" : 'img/lk/default.png'?>'); background-size: cover">
                                <div class="example-2">
                                    <div class="form-group">

                                        <form action="actions/avatar.php" class="avatar" enctype="multipart/form-data" method="post">
                                            <input type="file" name="file" id="file" class="input-file" required>
                                            <label for="file" class="btn btn-tertiary js-labelFile">
                                                <i class="icon fa fa-check"></i>
                                                <span class="js-fileName">Сменить аватар</span>
                                            </label>
                                            <input class="example-2__submit" name="avatar" type="submit">
                                        </form>

                                    </div>
                                </div>
                            </div>
						</div>
						
						<div class="lk-block__right">
							<div class="lk-block__name">
                                <input class="lk-input lk-username" type="text" value="<?=$data['username']?>" readonly>
                                <span class="mdi mdi-settings lk-edit"></span>
                                <button class="lk-edit__btn hide">Сохранить</button>
                                <span class="help-span lk-help__span"></span>
                            </div>

							<div class="lk-block__info">

								<div class="lk-block__country">
									<div class="lk-block__country-content">
										<span class="mdi mdi-home"></span>
										<div class="lk-block__country-item">Страна</div>
									</div>
									<div class="lk-block__country-title">
                                        <input class="lk-input" type="text" value="<?=$data['country']?>" readonly>
                                    </div>
								</div>

								<div class="lk-block__birth">
									<div class="lk-block__birth-title">Родился</div>
									<div class="lk-block__birth-date">
                                        <input class="lk-input" type="date" value="<?=$data['date'] ? : '1999-01-01'?>" readonly>
                                    </div>
								</div>

							</div>

							<div class="lk-block__descr">
                                <div class="lk-block__birth-title">О себе (максимально 75 символов)</div>
                                <textarea cols="60" rows="2" class="lk-input lk-textarea" readonly><?=$data['descr'] ? : '-'?></textarea>
							</div>
                        </div>
                    </div>

                        <!--  Карта -->

                        <div class="map-wrap">
                            <div id="map"></div>
                        </div>

                        <!-- События -->
                        <div class="lk-block__button">
                            <button class="button-lk__add">Добавить событие</button>
                        </div>


                        <!-- event-item start -->
                        <div class="event-list">
                        <? foreach ($events as $event) {?>

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
                                        <img data-id="<?=$event['id']?>" class="deleteEvent" src="img/icons/trash.png" alt="delete">
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
                        <? }
                        if (!$events) { ?>
                            <h2>У вас пока нет событий :(</h2>
                            <h4>Добавьте первое!</h4>
                        <? } ?>
                        </div>

					</div>
				</div>
            </div>
        </div>
	</section>
	<!-- lk end -->

<div class="overlay">
</div>

<!--Для создания нового-->
<form method="POST" action="" class="newEvent makeNewEvent popupAll">

    <h2>Добавление нового события</h2>
    <input type="hidden" value="">
    <div class="input-newEvent">
        <input class="input-name" type="text" name="event-title" required="" placeholder="Название события">
    </div>
    <div class="input-newEvent">
        <input class="input-mail" type="text" name="event-place" required="" placeholder="Адрес события">
    </div>
    <div class="input-newEvent">
        <input class="input-name input-date" type="text" name="event-date" required="" placeholder="Дата в формате ГГГГ-ММ-ДД">
    </div>
    <div class="input-newEvent">
        <textarea name="event-descr" required="" placeholder="Описание события" rows="3"></textarea>
    </div>
    <button class="button button-event button-form__reg" type="submit">ДОБАВИТЬ СОБЫТИЕ</button>

</form>

<!--Для редактирования старого-->
<form method="POST" action="" class="newEvent changeOldEvent popupAll">
</form>

    <div class="popup-newEvent popupAll">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
        <h2>Событие успешно добавлено</h2>
        <p>В ближайшее время оно появится на карте</p>
    </div>
    <!-- /.popup -->

    <form method="POST" action="" class="popup-support popupAll">

        <h2>Форма обратной связи</h2>
        <input type="hidden" value="">
        <div>
            <input class="input-support" type="text" name="support-username" required="" placeholder="Ваше имя">
        </div>
        <div>
            <input class="input-support" type="text" name="support-phone" required="" placeholder="Ваш телефон">
        </div>
        <div>
            <input class="input-support" type="email" name="support-email" required="" placeholder="Ваша почта">
        </div>
        <div>
            <textarea class="input-support" name="support-descr" required="" placeholder="Суть проблемы" rows="3"></textarea>
        </div>
        <button class="button button-event button-form__reg" type="submit">Отправить заявку</button>
        <span class="mail-loading"></span>

    </form>

    <div class="popup-support-recieve popupAll">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
        <h2>Мы получили вашу заявку и скоро свяжемся с вами!</h2>
    </div>
    <!-- /.popup -->

    <div class="popup-thankyou">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
        <h2>Информация успешно обновлена</h2>
    </div>
    <!-- /.popup -->



<!-- footer start -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-12">

                <div class="footer-block">
                    <div class="footer-block__lic order-3">
                        <a href="#">© все права защищены</a>
                    </div>

                    <div class="footer-block__social order-4">
                        <a href="#"><span class="mdi mdi-vk"></span></a>
                        <a href="#"><span class="mdi mdi-odnoklassniki"></span></a>
                        <a href="#"><span class="mdi mdi-facebook"></span></a>
                        <a href="#"><span class="mdi mdi-youtube"></span></a>
                    </div>
                    </div>

            </div>

        </div>

    </div>
</footer>
<!-- footer end -->



	  <!-- .script -->
<script src="js/jquery-3.3.1.min.js"></script>
 <!-- Custom js -->
<script src="js/script.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/fancybox-3.2.11.js"></script>
<script src="slick/slick.min.js"></script>
<script src="js/time.js"></script>
<script src="js/flexmenu.js"></script>
<script src="js/lk.js"></script>
<script src="js/event.js"></script>

<?
$events = $connect->query("SELECT place, title FROM events WHERE user_id='$id'");
$events = $events->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
    ymaps.ready(init);

    var mainCoordinates = [];
    $.getJSON('https://geocode-maps.yandex.ru/1.x/?apikey=ab380256-636c-4346-8de3-8177483ab96f&format=json&geocode=Москва&results=1', function (data) {
        mainCoordinates = data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ');
    });

    window.events = [[], []];
    <?
    if ($events) {
    foreach ($events as $event) { ?>
    $.getJSON('https://geocode-maps.yandex.ru/1.x/?apikey=ab380256-636c-4346-8de3-8177483ab96f&format=json&geocode=<?=$event['place']?>&results=1', function (data) {
        window.events[0].push(data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' '));
        window.events[1].push('<?=$event['title']?>');
        });
    <? }} ?>

        function init() {
        var myMap = new ymaps.Map("map", {
                center: [mainCoordinates[1], mainCoordinates[0]],
                zoom: 4
            }, {
                searchControlProvider: 'yandex#search'
            }),

            collection = new ymaps.GeoObjectCollection(null, {
                preset: 'islands#circleIcon',
                iconColor: 'blue'
            }),
            coords = [];

            for (let i = 0; i < window.events[0].length; i++) {
                coords.push([window.events[0][i][1], window.events[0][i][0]]);
            }

            for (let i = 0; i < coords.length; i++) {
                collection.add(new ymaps.Placemark(coords[i],
                    {
                        hintContent: window.events[1][i],
                        balloonContent: window.events[1][i],
                    }));
            }
            myMap.geoObjects.add(collection)
            myMap.behaviors.disable('scrollZoom')
            // Через коллекции можно подписываться на события дочерних элементов.
            //collection.events.add('click', function () { alert('Кликнули по желтой метке') });

            // Через коллекции можно задавать опции дочерним элементам.
            //blueCollection.options.set('preset', 'islands#blueDotIcon');
        }
</script>

</body>
</html>