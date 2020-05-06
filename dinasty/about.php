<?php
require_once 'header.php';
require_once 'actions/db.php';
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

<!-- features start -->
<section class="features" style="top: 20px; margin: 40px">
    <div class="container">
        <div class="row">

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="features-block">
                    <img src="img/time-management.png" alt="">
                    <div class="features-block__title">Время</div>
                    <div class="features-block__descr">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit dicta pariatur at corporis temporibus ullam officia adipisci repellat sed quibusdam.
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="features-block">
                    <img src="img/global-network.png" alt="">
                    <div class="features-block__title">Место</div>
                    <div class="features-block__descr">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit dicta pariatur at corporis temporibus ullam officia adipisci repellat sed quibusdam.
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="features-block">
                    <img src="img/earth-grid.png" alt="">
                    <div class="features-block__title">Взаимодействие</div>
                    <div class="features-block__descr">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit dicta pariatur at corporis temporibus ullam officia adipisci repellat sed quibusdam.
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="features-block">
                    <img src="img/family-tree.png" alt="">
                    <div class="features-block__title">Семейное древо</div>
                    <div class="features-block__descr">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit dicta pariatur at corporis temporibus ullam officia adipisci repellat sed quibusdam.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- features end -->

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