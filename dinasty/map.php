<?
 session_start();

$id = $_SESSION['userId'];

require_once 'actions/db.php';
require_once 'header.php';

    $allUsers = $connect->query("SELECT username, city FROM users");
    $allUsers = $allUsers->fetchAll(PDO::FETCH_ASSOC);

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

    <section class="map">
        <div class="container">
            <h2 class="map-header">Всего пользователей на сайте: <?=count($allUsers)?></h2>
            <div class="map-wrap">
                <div id="map"></div>
            </div>
        </div>
    </section>


<!-- footer start -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-12">

                <div class="footer-block">
                    <div class="footer-block__lic order-3">
                        <a href="#">© all rights reserved</a>
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

<div class="overlay"></div>
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

	  <!-- .script -->
<script src="js/jquery-3.3.1.min.js"></script>
 <!-- Custom js -->
<script src="js/script.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/fancybox-3.2.11.js"></script>
<script src="slick/slick.min.js"></script>
<script src="js/time.js"></script>
<script src="js/flexmenu.js"></script>

<script>
    $('.support-mail').on('click', function () {
        event.preventDefault();
        $('.overlay').css('display', 'block');
        $('.popup-support').css('display', 'block');
    });

    $('.popup-support').on('submit', function () {
        event.preventDefault();
        $('.mail-loading').html("<img class=\"loading-img\" src=\"img/load.gif\" alt=\"loading\">");
        $.ajax({
            type: 'POST',
            url: 'actions/support.php',
            data: $(this).serialize(),
            success: function () {
                $('.popup-support').css('display', 'none');
                $('.popup-support-recieve').css('display', 'block');
            },
            error: function () {
                alert('error');
            }
        });
    });
</script>


<script>
    ymaps.ready(init);

    var mainCoordinates = [];
    $.getJSON('https://geocode-maps.yandex.ru/1.x/?apikey=ab380256-636c-4346-8de3-8177483ab96f&format=json&geocode=Москва&results=1', function (data) {
        mainCoordinates = data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ');
    });

    window.events = [[], []];
    <? foreach ($allUsers as $user) { ?>
    $.getJSON('https://geocode-maps.yandex.ru/1.x/?apikey=ab380256-636c-4346-8de3-8177483ab96f&format=json&geocode=<?=$user['city']?>&results=1', function (data) {
        window.events[0].push(data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' '));
        window.events[1].push('<?=$user['username']?>');
        });
    <? } ?>

        function init() {
        var myMap = new ymaps.Map("map", {
                center: [mainCoordinates[1], mainCoordinates[0]],
                zoom: 4
            }, {
                searchControlProvider: 'yandex#search'
            }),

            collection = new ymaps.GeoObjectCollection(null, {
                preset: 'islands#circleIcon',
                iconColor: 'red'
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