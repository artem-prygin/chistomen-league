let btnEv = document.querySelector('.button-lk__add');
let formEv = document.querySelector('.makeNewEvent');
let ev = document.querySelectorAll('.newEvent');
let overlay = document.querySelector('.overlay');

btnEv.addEventListener('click', function () {
    formEv.style.display = 'block';
    overlay.style.display = 'block';
});

overlay.addEventListener('click', function () {
    for (let i=0; i<ev.length; i++) {
        ev[i].style.display = 'none';
    }
    this.style.display = 'none';
});

let newEvent = document.querySelector('.newEvent');
newEvent.addEventListener('submit', function () {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'actions/addEvent.php',
        data: $(this).serialize(),
        success: function (res) {
            $('form').trigger('reset');
            $('.map-wrap').css('display', 'block');
            $('.event-list').html(res);
            $('.popupAll').css('display', 'none');
            $('.popup-newEvent').css('display', 'block');
        },
        error: function () {
            alert('Ошибка');
        }
    });
});

// обновить информацию о событии и просмотреть событие
let updateEvent = document.querySelector('.event-list');

updateEvent.addEventListener('click', function (event) {
    if (event.target.classList.contains('updateEvent')) {
        event.preventDefault();
        let id = event.target.getAttribute('data-id');
        $.ajax({
            type: 'GET',
            url: 'actions/preUpdateEvent.php',
            data: {id: id},
            success: function (res) {
                $('.changeOldEvent').html(res);
                $('.overlay, .changeOldEvent').css('display', 'block');
            },
            error: function () {
                alert('Ошибка');
            }
        });
    }
});

$('.changeOldEvent').on('submit', function () {
    if (document.querySelector('.input-date').value.length > 1) {
        alert(1);
    }
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'actions/updateEvent.php',
        data: $(this).serialize(),
        success: function () {
            window.location.reload();
        },
        error: function () {
            alert('Ошибка');
        }
    });
});


// кнопка Подробнее и удаление события
$('.event-list').on('click', function (e) {
    if (e.target.classList.contains('event-item-button-more')) {
        let id = e.target.getAttribute('data-id');
        let more = document.querySelector(`[data-more='${id}']`);
        more.classList.toggle('hide');
    }

    if (e.target.classList.contains('deleteEventWrap') || e.target.classList.contains('deleteEvent')) {
        event.preventDefault();
        let id = e.target.getAttribute('data-id');
        if (confirm('Точно удалить событие?')) {
            $.ajax({
                type: 'POST',
                url: 'actions/deleteEvent.php',
                data: {id: id},
                success: function () {
                    window.location.reload();
                },
                error: function () {
                    alert('Ошибка');
                }
            });
        }
    }
});















