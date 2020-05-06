<?php
session_start();
require_once 'actions/db.php';

$id = $_SESSION['userId'];
$isAdmin = $connect->query("SELECT email FROM users WHERE id='$id'");
$isAdmin = $isAdmin->fetch();

if (isset($_POST['news-date'])) {
    $date = trim(htmlspecialchars($_POST['news-date']));
    $descr = trim(htmlspecialchars($_POST['news-descr']));

    $query = $connect->prepare("INSERT INTO `dinasty_news` (date, descr) VALUES (:date, :descr)");
    $arr = ["date" => $date, "descr" => $descr];
    $query->execute($arr);

    header("Location: news.php");
}

require_once 'header.php';


?>

<!-- header start -->
<header class="header wow fadeIn slower" data-wow-delay="0.6s">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="header-block__logo">
                    <a href="/"><img src="img/logo.png" alt="Logo"></a>
                </div>
            </div>
            <div class="col-6">
                <div class="header-lk-block__nav">
                    <a id="menu-button"></a>
                    <div id="hamburger-menu">
                        <nav>
                            <a href="index.php">Главная</a>
                            <a href="map.php">Карта участников</a>
                            <a href="" class="support-mail">Помощь</a>
                            <a href="news.php">Новости</a>
                            <a href="about.php">О нас</a>
                        </nav>
                    </div>
                    <div id="overlay"></div>
                </div>
            </div>
            <!--				<div class="col-6">-->
            <!--					<div class="header-block__lang">-->
            <!--						<div class="header-block__lang-change">Rus</div>-->
            <!--						<span class="mdi mdi-menu-down"></span>-->
            <!--					</div>-->
            <!--				</div>-->
        </div>
    </div>
</header>
<!-- header end -->

<!-- news start -->
<section class="news" style="margin: 20px">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="news-block">
                    <h2>Новости проекта</h2>
                    <div class="news-block__content">

                        <?
                        $news = $connect->query("SELECT * FROM dinasty_news");
                        $news = $news->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($news as $article) { ?>

                        <div class="news-block__content-item">
                            <div class="news-block__content-item-date"><?=$article['date']?></div>
                            <div class="news-block__content-item-text">
                                <?=$article['descr']?>
                            </div>
                        </div>

                        <? } ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- news end -->

<? if ($isAdmin['email'] == 'joniliptikus@gmail.com') { ?>
<div class="container">
        <form action="" method="post" style="display: flex; flex-direction: column; align-items: center; border: 1px solid black; ">
            <h2>Новая новость</h2>
            <input style="border: 1px solid black; width: 400px; padding: 5px; margin: 5px" type="text" name="news-date" placeholder="Дата в удобном формате" required>
            <textarea style="border: 1px solid black; width: 400px; padding: 5px; margin: 5px" name="news-descr" rows="10" placeholder="Текст новости" required></textarea>
            <input type="submit" class="button-form__reg" style="cursor: pointer">
        </form>
</div>
<? } ?>

<!-- footer start -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-12">

                <div class="footer-block">
                    <div class="footer-block__lic order-3">
                        <a href="http://gasar.ru/">Разработка сайтов: http://gasar.ru/</a>
                        <a href="test.pdf" download="">Скачать договор оферты</a>
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

<script src="js/flexmenu.js"></script>

<!-- Ajax -->
<script src="js/ajax.js"></script>

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