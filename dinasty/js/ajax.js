//смена ползунка
var conf = false;
var send = false;
var passCheck = false;
var newEmail = 0;
var country = false;

$('#switch').change(function() {
   conf = !conf;
   $('.span-conf').html('');
});

let inputEmail = document.querySelectorAll('.input-mail');
inputEmail[0].addEventListener('input', function () {
    let checkEmail = this.value;
    $.ajax({
        type: 'POST',
        url: 'actions/checkEmail.php',
        data: {checkEmail: checkEmail},
        success: function (res) {
            $('.input-mail__span').html(res);
            if ($('.input-mail__span>span').html() == 'Email свободен') {
                newEmail = 1;
            } else {
                newEmail = 0;
            }
        },
        error: function () {
            alert('Ошибка');
        }
    });
});

inputEmail[1].addEventListener('input', function () {
    let findEmail = this.value;
    $.ajax({
        type: 'POST',
        url: 'actions/findEmail.php',
        data: {findEmail: findEmail},
        success: function (res) {
            $('.input-mail__span2').html(res);
        },
        error: function () {
            alert('Ошибка');
        }
    });
});

inputEmail[2].addEventListener('input', function () {
    let findEmail = this.value;
    $.ajax({
        type: 'POST',
        url: 'actions/findEmail.php',
        data: {findEmail: findEmail},
        success: function (res) {
            $('.input-mail__span3').html(res);
            if ($('.input-mail__span3>span').html() == 'Мы нашли ваш email :)') {
                newEmail = 1;
            } else {
                newEmail = 0;
            }
        },
        error: function () {
            alert('Ошибка');
        }
    });
});

$('.input-pass-check').on('input', function () {
    send = true;
    if ($('.input-pass').val() !== $('.input-pass-check').val()) {
        $('.input-pass__label').html('Пароли не совпадают');
        passCheck = false;
    } else {
        $('.input-pass__label').html("<span style='color: green'>Пароли совпадают</span>");
        passCheck = true;
    }
});

//восстановление пароля

$('.input-pass-check2').on('input', function () {
    send = true;
    if ($('.input-pass2').val() !== $('.input-pass-check2').val()) {
        $('.input-pass__label2').html('Пароли не совпадают');
        passCheck = false;
        console.log(passCheck);
    } else {
        $('.input-pass__label2').html("<span style='color: green'>Пароли совпадают</span>");
        passCheck = true;
        console.log(passCheck);
    }
});

//отправка формы регистрации
$('.reg-form').on('submit', function () {
    event.preventDefault();
    if (!conf) {
        $('.span-conf').html('Необходимо принять соглашение');
    }
    if (newEmail === 1 && country===true && passCheck===true && conf===true && send===true) {
        send = false;
        $('.mail-loading').html("<img class=\"loading-img\" src=\"img/load.gif\" alt=\"loading\">");
        $.ajax({
            type: 'POST',
            url: 'actions/mail.php',
            data: $(this).serialize(),
            success: function (res) {
                conf = false;
                $("form").trigger('reset');
                $('.help-span').html('');
                $('.span-conf').html('');
                $('.mail-loading').html('');
                $('.popupAll').css('display', 'none');
                $('.popup-thankyou').css('display', 'block');
            },
            error: function () {
                alert('Ошибка');
            }
        });
    }
});

//логин
$('.login-form').on('submit', function () {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'actions/login.php',
        data: $(this).serialize(),
        success: function(response) {
            response = JSON.parse(response);
            if (response.message) {
                $('.unsuccess-login').html(response.message);
            } else {
                window.location ='lk.php';
            }
        }
    });
});

//сброс пароля


$('.popup-remind-form').on('submit', function () {
    event.preventDefault();
        if (newEmail === 1) {
            $('.mail-loading').html("<img class=\"loading-img\" src=\"img/load.gif\" alt=\"loading\">");
            $.ajax({
                type: 'POST',
                url: 'actions/remind.php',
                data: $(this).serialize(),
                success: function () {
                    $("form").trigger('reset');
                    $('.mail-loading').html('');
                    $('.popupAll').css('display', 'none');
                    $('.popup-checkEmail').css('display', 'block');
                },
                error: function () {
                    alert('Ошибка');
                }
            });
        }
    });


//новый пароль

$('.changePass').on('submit', function () {
    event.preventDefault();
    if (passCheck === true) {
        $.ajax({
            type: 'POST',
            url: 'actions/changePass.php',
            data: $(this).serialize(),
            success: function (res) {
                $("form").trigger('reset');
                $('.popupAll').css('display', 'none');
                $('.popup-passChange').css('display', 'block');
            },
            error: function () {
                alert('Ошибка');
            }
        });
    }
});


// ввод страны

$('.input-country').on('input', function () {
   this.value = this.value.replace(/[^А-Яа-я \-]/ig, '');
    this.value = this.value.substr('0', 1).toUpperCase() + this.value.substr('1', 30);
    let checkCountry = this.value;
    $.ajax({
        type: 'POST',
        url: 'actions/checkCountry.php',
        data: {checkCountry: checkCountry},
        success: function (res) {
            $('.input-country__span').html(res);
        },
        error: function () {
            alert('Ошибка');
        }
    });
});

// ввод города

$('.input-city').on('input', function () {
    this.value = this.value.replace(/[^А-Яа-я \-]/ig, '');
    this.value = this.value.substr('0', 1).toUpperCase() + this.value.substr('1', 50);
});















