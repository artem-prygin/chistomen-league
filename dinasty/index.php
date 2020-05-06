<?
session_start();
if ($_SESSION['userId']) {
    header("Location: lk.php");
}

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once 'header.php';

require_once 'actions/db.php';
if ($_GET['auth']) {
    $auth = $_GET['auth'];
    $query = $connect->exec("UPDATE users SET `validation`=true WHERE `auth_key`='$auth'");
    if ($query) {
        echo "
            <div class=\"overlay\" style='display: block;'></div>
                <div class=\"popup-thankyou popupAll\" style='display: block;'>
                <div class=\"popup-close\">
                &times;
                </div>
                <!-- /.popup-close -->
				    <h2 style='margin-bottom: 20px'>Вы успешно зарегистрировались</h2>
				    <div class=\"popup-thankyou_descr\">
					<p>Теперь вы можете зайти в свой личный кабинет</p>
				    </div>
				    <!-- /.descr -->
		        </div>
		        <!-- /.popup -->
        ";
    }
}

if ($_GET['passAuth']) {
    $auth = $_GET['passAuth'];
    $query = $connect->query("SELECT * FROM users WHERE remindPass='$auth'");
    $query = $query->fetch();
    if ($query) {
        echo "
            <div class=\"overlay\" style='display: block;'></div>
                <div class=\"popup-thankyou popupAll\" style='display: block;'>
                <div class=\"popup-close\">
                &times;
                </div>
                <!-- /.popup-close -->
				    <h2 style='margin-bottom: 20px'>Задайте новый пароль</h2>
				    
				    <form action='' class='changePass'>
				    <input type='hidden' value='$auth' name='auth'>
				    <div class=\"input-mail__block\">
                        <img class=\"input-icon input-icon-rem\" src=\"img/icons/padlock.png\" alt=\"password\">
                        <input class=\"input-pass input-pass2 input-pass-rem\" type=\"password\" name=\"pass-new\" required=\"\" placeholder=\"Пароль\">
                    </div>

                    <div class=\"input-mail__block\">
                        <img class=\"input-icon input-icon-rem\" src=\"img/icons/padlock.png\" alt=\"password\">
                        <input class=\"input-pass-check input-pass-check2 input-pass-rem\" type=\"password\" name=\"pass-check-new\" required=\"\" placeholder=\"Подтверждение пароля\">
                        <label class=\"input-pass__label input-pass__label2 help-span\" for=\"date\"></label>
                    </div>
                    
                    <button class=\"button button-form__reg\" type=\"submit\">Изменить пароль</button>
                    
                    </form>
				    <!-- /.descr -->
		        </div>
		        <!-- /.popup -->
        ";
    }
}

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

	<!-- main start -->
	<section class="main wow fadeIn slower" data-wow-delay="0.6s">
		<div class="container">
			<div class="row">
				<div class="col-12">

					<div class="main-block">

						<div class="main-block__left order-1">
							<h1 class="wow fadeIn slower" data-wow-delay="1.5s">Сервис регистрации на планете земля</h1>
							<div class="main-block__button wow fadeIn slower" data-wow-delay="3s">
								<button class="button-main button-reg button-main-o">Регистрация</button>
								<button class="button-main button-login">Войти</button>
							</div>
						</div>

						<div class="main-block__right order-2 wow fadeIn slower" data-wow-delay="2.2s">
								<img class="clock-01" src="img/main/watches_02.png" alt="Clock-01">
								<img class="clock-02" src="img/main/watches_01.png" alt="Clock-02">
								<img class="clock-03" src="img/main/watches_03.png" alt="Clock-03">
						</div>

					</div>

					<div class="main-block__social">
						<a class="wow fadeIn slower" data-wow-delay="2.6s" href="#"><span class="mdi mdi-vk"></span></a>
						<a class="wow fadeIn slower" data-wow-delay="2.8s" href="#"><span class="mdi mdi-odnoklassniki"></span></a>
						<a class="wow fadeIn slower" data-wow-delay="3s" href="#"><span class="mdi mdi-facebook"></span></a>
						<a class="wow fadeIn slower" data-wow-delay="3.2s" href="#"><span class="mdi mdi-youtube"></span></a>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- main end -->

	<!-- features start -->
	<section class="features">
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

	<!-- news start -->
	<section class="news">
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

							<div class="news-block__button">
								<a href="news.php">Подробнее</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- news end -->

	<!-- comments slider start -->
    <section class="comments">
			<div class="container-fluid">
				<div class="row">

					<div class="col-12">
						<h2 class="section-title section-title__comments">Отзывы</h2>

	    <div class="comments-slider">

						<div class="comments-block">
							<div class="comments-block__container">
								<div class="comments-block__container-img1"></div>
								<div class="comments-block__container-title">
									<div class="comments-block__container-title-name">Shannon Gonzalez</div>
									<div class="comments-block__container-title-location">
										<span class="mdi mdi-home"></span>
										<div class="comments-block__container-title-location-text">
											Spain
										</div>
									</div>
								</div>
							</div>

							<div class="comments-block__descr">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime culpa hic magni, error minima fugit rem iure suscipit aliquam. Voluptatum, tempora, totam. Reiciendis recusandae magni ab, harum doloremque odio. Nulla.
							</div>
							<div class="comments-block-bottom__info">
								<div class="comments-block__container-title-star"></div>
								<div class="comments-block__date">12.02.2019 г.</div>
							</div>
						</div>

						<div class="comments-block">
							<div class="comments-block__container">
								<div class="comments-block__container-img1"></div>
								<div class="comments-block__container-title">
									<div class="comments-block__container-title-name">Shannon Gonzalez</div>
									<div class="comments-block__container-title-location">
										<span class="mdi mdi-home"></span>
										<div class="comments-block__container-title-location-text">
											Spain
										</div>
									</div>
								</div>
							</div>

							<div class="comments-block__descr">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime culpa hic magni, error minima fugit rem iure suscipit aliquam. Voluptatum, tempora, totam. Reiciendis recusandae magni ab, harum doloremque odio. Nulla.
							</div>
							<div class="comments-block-bottom__info">
								<div class="comments-block__container-title-star"></div>
								<div class="comments-block__date">12.02.2019 г.</div>
							</div>
						</div>

						<div class="comments-block">
							<div class="comments-block__container">
								<div class="comments-block__container-img1"></div>
								<div class="comments-block__container-title">
									<div class="comments-block__container-title-name">Shannon Gonzalez</div>
									<div class="comments-block__container-title-location">
										<span class="mdi mdi-home"></span>
										<div class="comments-block__container-title-location-text">
											Spain
										</div>
									</div>
								</div>
							</div>

							<div class="comments-block__descr">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime culpa hic magni, error minima fugit rem iure suscipit aliquam. Voluptatum, tempora, totam. Reiciendis recusandae magni ab, harum doloremque odio. Nulla.
							</div>
							<div class="comments-block-bottom__info">
								<div class="comments-block__container-title-star"></div>
								<div class="comments-block__date">12.02.2019 г.</div>
							</div>
						</div>

						<div class="comments-block">
							<div class="comments-block__container">
								<div class="comments-block__container-img1"></div>
								<div class="comments-block__container-title">
									<div class="comments-block__container-title-name">Shannon Gonzalez</div>
									<div class="comments-block__container-title-location">
										<span class="mdi mdi-home"></span>
										<div class="comments-block__container-title-location-text">
											Spain
										</div>
									</div>
								</div>
							</div>

							<div class="comments-block__descr">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime culpa hic magni, error minima fugit rem iure suscipit aliquam. Voluptatum, tempora, totam. Reiciendis recusandae magni ab, harum doloremque odio. Nulla.
							</div>
							<div class="comments-block-bottom__info">
								<div class="comments-block__container-title-star"></div>
								<div class="comments-block__date">12.02.2019 г.</div>
							</div>
						</div>

						<div class="comments-block">
							<div class="comments-block__container">
								<div class="comments-block__container-img1"></div>
								<div class="comments-block__container-title">
									<div class="comments-block__container-title-name">Shannon Gonzalez</div>
									<div class="comments-block__container-title-location">
										<span class="mdi mdi-home"></span>
										<div class="comments-block__container-title-location-text">
											Spain
										</div>
									</div>
								</div>
							</div>

							<div class="comments-block__descr">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime culpa hic magni, error minima fugit rem iure suscipit aliquam. Voluptatum, tempora, totam. Reiciendis recusandae magni ab, harum doloremque odio. Nulla.
							</div>
							<div class="comments-block-bottom__info">
								<div class="comments-block__container-title-star"></div>
								<div class="comments-block__date">12.02.2019 г.</div>
							</div>
						</div>


					</div>
				</div>
			</div>
		</section>
	<!-- comments slider end -->

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

	<!-- reg form start -->
	<div class="overlay">
    </div>



    <div class="popup popupAll">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
        <div class="popup-form">
            <div class="popup-form__logo">
                <img src="img/logo-form.png" alt="Logo">
            </div>
            <h2>Регистрация</h2>
                <form method="POST" class="popup-form reg-form form-control" id="form1" name="form1">

                    <div class="input-mail__block">
                        <img class="input-icon" src="img/icons/login.png" alt="Login">
                        <input class="input-name" type="text" name="name" required="" placeholder="Ваше имя">
                    </div>

                    <div class="input-mail__block">
                        <img class="input-icon" src="img/icons/envelope.png" alt="email">
                        <input class="input-mail" type="email" name="email" required="" placeholder="Ваш E-mail">
                        <span class="input-mail__span help-span"></span>
                    </div>

                    <div class="input-mail__block">
                        <img class="input-icon" src="img/icons/padlock.png" alt="password">
                        <input class="input-pass" type="password" name="pass" required="" placeholder="Пароль">
                    </div>

                    <div class="input-mail__block">
                        <img class="input-icon" src="img/icons/padlock.png" alt="password">
                        <input class="input-pass-check" type="password" name="pass-check" required="" placeholder="Подтверждение пароля">
                        <label class="input-pass__label help-span"></label>
                    </div>

                    <div class="input-mail__block">
                        <img class="input-icon" src="img/icons/placeholder.png" alt="country">
                        <input class="input-name input-country" type="text" name="country" required="" placeholder="Ваша страна (русскими буквами)">
                        <span class="input-country__span help-span"></span>
                    </div>

                    <div class="input-mail__block">
                        <img class="input-icon" src="img/icons/house.png" alt="city">
                        <input class="input-name input-city" type="text" name="city" required="" placeholder="Ваш город (русскими буквами)">
                    </div>

                    <div class="captcha-check input-mail__block">
                        <input class="input-custom" type="checkbox" name="check" id="switch" style="display:none"/>
                        <label class="checkbox-custom" for="switch"></label>
                        <span>Я ознакомился и принимаю
                            <a href="test.pdf" download="">пользовательское соглашение</a>
                            <span class="span-conf" style="color: red; font-size: 10px; display: block"></span>
                        </span>
                    </div>
                    <!-- captcha end -->

                    <button class="button button-form__reg" type="submit" id="continue-reg">Регистрация</button>
                    <span class="mail-loading"></span>

                </form>
        </div>
        <!-- /.popup-form -->
    </div>

    <div class="popup-login popupAll">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
        <div class="popup-login-form">
            <div class="popup-login-form__logo">
                <img src="img/logo-form.png" alt="Logo">
            </div>
            <h2>Вход</h2>
                <form class="popup-login-form login-form" id="form2" name="form2" method="post">
                    <div class="input-mail__block input-mail__block-login">
                    <input class="input-login__mail input-mail" type="text" name="userEmail" required="" placeholder="Ваш E-mail">
                    <span class="input-mail__span2 help-span"></span>
                    </div>
                    <input class="input-login__pass" type="password" name="userPass" required="" placeholder="Пароль">
                    <div class="input-login__remind">Забыли пароль?</div>
                    <button class="button button-form__login" type="submit" id="continue">Вход</button>
                </form>


            <span class="unsuccess-login"></span>
        </div>
        <!-- /.popup-form -->
    </div>

    <div class="popup-remind popupAll">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
        <div class="popup-login-form">
            <div class="popup-login-form__logo">
                <img src="img/logo-form.png" alt="Logo">
            </div>

            <form class="popup-remind-form" method="post" action="">
                <div class="input-mail__block input-mail__block-login">
                    <input class="input-login__mail input-mail" type="text" name="userEmail-remind" required="" placeholder="Ваш E-mail">
                    <span class="input-mail__span3 help-span"></span>
                </div>
                <button class="button button-form__login" type="submit" style="display: block; margin: auto">Сбросить пароль</button>
                <span class="mail-loading"></span>
            </form>

        </div>
    <!-- /.popup-form -->
    </div>

    <div class="popup-thankyou popupAll">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
            <h2>спасибо за регистрацию</h2>
            <div class="overlay-thankyou-img">
                <img src="img/form-clock.png" alt="">
            </div>
            <div class="popup-thankyou_descr">
                <p>Для завершения регистрации, пожалуйста, пройдите по ссылке, высланной на Вашу электронную почту. Если не пришло письмо с подтверждением, посмотрите, пожалуйста, в папке "Спам"</p>
            </div>
            <!-- /.descr -->
    </div>

    <div class="popup-checkEmail popupAll">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
        <h2>Проверьте почтовый ящик</h2>
        <div class="popup-thankyou_descr">
            <p>Мы выслали вам ссылку для восстановления пароля</p>
        </div>
        <!-- /.descr -->
    </div>

    <div class="popup-passChange popupAll">
        <div class="popup-close">
            &times;
        </div>
        <!-- /.popup-close -->
        <h2>Пароль успешно изменен</h2>
        <div class="popup-thankyou_descr">
            <p>Заходите в личный кабинет :)</p>
        </div>
        <!-- /.descr -->
    </div>

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

</body>
</html>