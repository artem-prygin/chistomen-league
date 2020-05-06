<!-- header start -->
<header class="header-lk">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-6">
                <div class="header-lk-block__logo">
                    <img src="img/logo.png" alt="Logo">
                </div>
            </div>

            <? if (isset($_SESSION['userId'])) { ?>
            <div class="d-none d-sm-block col-sm-4">
                <div class="header-lk-block__avatar">
                    <div class="header-lk-block__avatar-name"><?=$data['username']?></div>

                    <div class="header-lk-block__avatar-img">
                        <img src="<?=$data['img'] ? "img/user{$data['id']}/{$data['img']}" : 'img/lk/default.png'?>" alt="Avatar">
                    </div>
                </div>
            </div>
            <? } ?>

            <? if (isset($_SESSION['userId'])) { ?>
            <div class="col-2">
                <div class="header-lk-block__nav">
                    <a id="menu-button"></a>
                    <div id="hamburger-menu">
                        <nav>
                            <a href="lk.php">Профиль</a>
                            <form action="actions/logout.php" method="post">
                                <input class="logout" type="submit" value="Выйти" name="logout">
                            </form>
                            <a href="map.php">Карта участников</a>
                            <a href="" class="support-mail">Помощь</a>
                            <a href="">Баланс: 350 руб.</a>
                        </nav>
                    </div>
                    <div id="overlay"></div>
                </div>
            </div>
            <? } else { ?>
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
            <? } ?>
        </div>
    </div>
</header>
<!-- header end -->