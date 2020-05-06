// ЛК

let edit = document.querySelector('.lk-edit');
let lkInfo = document.querySelectorAll('.lk-input');
let lkBtn = document.querySelector('.lk-edit__btn');

edit.addEventListener('click', function () {
    $('.lk-help__span').html('');
    lkBtn.classList.toggle('hide');
    for (let i=0; i<lkInfo.length; i++) {
        lkInfo[i].hasAttribute('readonly') ? lkInfo[i].removeAttribute('readonly') : lkInfo[i].setAttribute('readonly', '');
        lkInfo[i].classList.toggle('lk-input__active');
    }
});

lkBtn.addEventListener('click', function () {
    let username = lkInfo[0].value;
    let country = lkInfo[1].value;
    let date = lkInfo[2].value;
    let descr = lkInfo[3].value;
    this.classList.add('hide');
    $.ajax({
        type: 'POST',
        url: 'actions/update.php',
        data: {username: username, country: country, date: date, descr: descr},
        success: function (res) {
            $('.lk-help__span').html(res);
            for (let i=0; i<lkInfo.length; i++) {
                lkInfo[i].setAttribute('readonly', '');
                lkInfo[i].classList.remove('lk-input__active');
            }
        },
        error: function () {
            alert('error');
        }
    });
});

//ввод в textarea профиля

let lkTextArea = document.querySelector('.lk-textarea');
lkTextArea.addEventListener('input', function () {
   this.value = this.value.substr(0,75);
});


let inputDate = $('.input-date');
let inputDateNew;

for (let i=0; i<inputDate.length; i++) {
    inputDate[i].addEventListener('input', function () {

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








