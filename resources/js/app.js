$(document).ready(function () {
    $('.like').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            type: 'post',
            data: $(this).serialize(),
            url: '/like',
            success: function (res) {
                let currentLikes = form.children('span').html();
                if (res == 1) {
                    form.children('span').html(--currentLikes);
                } else {
                    form.children('span').html(++currentLikes);
                }
                form.children('button').toggleClass('btn-danger').toggleClass('btn-success');
            }
        });
    });

    let edit = false;
    $('.profile-settings').click(function () {
        edit === false
            ? $('.profile-info input, .profile-info textarea').removeAttr('disabled')
            : $('.profile-info input, .profile-info textarea').attr('disabled')
        edit = !edit;

        $('.profile-block__showOnEdit, .profile-block__hideOnEdit').toggle();
    });

    $('.profile-info').submit(function (e) {
        e.preventDefault();
        $('.profile-alert').remove();
        $.ajax({
            type: 'put',
            data: $(this).serialize(),
            url: '/profile/1',
            success: function (res) {
                $('.error').html('');
                $('.profile-block__showOnEdit, .profile-block__hideOnEdit').toggle();
                $('.profile-info input, .profile-info textarea').attr('disabled', true);
                edit = false;

                console.log($('[name="instagram_link"]').val());

                let vk = $('[name="vk_link"]').val();
                let insta = $('[name="instagram_link"]').val();
                let about = $('[name="about"]').val();

                $('.profile-vk a').attr('href', vk).html(vk);
                vk === ''
                    ? $('.profile-vk a').attr('disabled', true).html('Ссылка не указана').addClass('placeholder')
                    : $('.profile-vk a').attr('disabled', false).removeClass('placeholder')


                $('.profile-instagram a').attr('href', insta).html(insta);
                insta === ''
                    ? $('.profile-instagram a').attr('disabled', true).html('Ссылка не указана').addClass('placeholder')
                    : $('.profile-instagram a').attr('disabled', false).removeClass('placeholder')


                about === ''
                    ? $('.profile-about p span').html('Нет информации').addClass('placeholder')
                    : $('.profile-about p span').html(about).removeClass('placeholder')

                $('.profile-container').prepend(
                    `<div class="alert alert-success alert-dismissible fade show profile-alert" role="alert">
                      <span>${res}</span>
                      <button class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                      </button>
                    </div>`);
            },
            error: function (err) {
                for (let errorMsg in err.responseJSON.errors) {
                    $('.error-' + errorMsg).html(err.responseJSON.errors[errorMsg][0]);
                }
                $('.profile-container').prepend(
                    `<div class="alert alert-danger alert-dismissible fade show profile-alert" role="alert">
                      <span>Что-то пошло не так, попробуйте еще раз</span>
                      <button class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                      </button>
                    </div>`);
            }
        })
    });

    // uploading avatars
    (function() {
        'use strict';
        $('.input-file').each(function() {
            let $input = $(this),
                $label = $input.next('.js-labelFile'),
                labelVal = $label.html();

            $input.on('change', function(element) {
                let fileName = '';
                if (element.target.value) fileName = element.target.value.split('\\').pop();
                fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);
            });
        });
    })();
    $('.profile-img__input').on('change', function () {
        $('.profile-img__upload').submit();
    });

    // posts slider at profile
    $('.post-blocks__slider').owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        navText: ["<i class='fa fa-chevron-left post-blocks__arrow post-blocks__arrow-left'></i>", "<i class='fa fa-chevron-right post-blocks__arrow post-blocks__arrow-right'></i>"],
        autoHeight: true
    })

});



