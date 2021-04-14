module.exports = function () {
    $(document).ready(function () {
        $('.yarazdelil-moderation__ok').click(function () {
            $(`td[data-id=${$(this).attr('data-id')}] span`).removeClass().addClass('green').html('Принято');
            $.ajax({
                url: '/yarazdelil/postConfirm',
                type: 'post',
                data: $(this).parent('form').serialize(),
                success: function () {
                    $('.yarazdelil-getWinner').fadeIn().css('display', 'block');
                }
            })
        })

        $('.yarazdelil-moderation__delete').click(function () {
            $(`td[data-id=${$(this).attr('data-id')}] span`).removeClass().addClass('red').html('Отклонено');
            let data = $(this).parent('form').serialize();
            $.ajax({
                url: '/yarazdelil/postDecline',
                type: 'post',
                data,
                success: function () {
                    return;
                }
            })
        })

        $('.yarazdelil-getWinner').click(function () {
            if(confirm('Точно провести розыгрыш?')) {
                let data = $('.getWinner').serialize();
                $('.yarazdelil-loading').fadeIn();
                setTimeout(function () {
                    $('.yarazdelil-loading').hide();
                },2500)
                setTimeout(function () {
                    $.ajax({
                        url: '/yarazdelil/getWinner',
                        type: 'post',
                        data,
                        success: function (res) {
                            $('.yarazdelil-winner').html(
                                `
                                <h3>Победитель: ${res.author}</h3>
                                <p>
                                <span>
                                Посмотреть пост:
                                </span>
                                <a href="${res.link}" target="_blank" onclick="popupWindow(this.href, this.target, window, 1500, 800)">
                                ${res.link}
                                </a>
                                </p>

                                `
                            ).css('padding-top', '25px');
                            $('.yarazdelil-getWinner').remove();
                            $('.lightgreen').removeClass('lightgreen');
                            $(`tr[data-id=${res.id}]`).addClass('lightgreen');
                        }
                    })
                },2500)
            }
        })


        $('.yarazdelil-changeVideo').click(function () {
            $(this).hide();
            $('.yarazdelil')
        });


        $('.yarazdelil-play').click(function () {
            $('.yarazdelil-play__popup, .yarazdelil-play__overlay').fadeIn(200);
            $('.yarazdelil-play__popup').css('display', 'flex');
            setTimeout(function () {
                $('.yarazdelil-play__popup iframe')
                    .height($('.yarazdelil-play__popup iframe').width() / 1.778)
                    .fadeIn();
            }, 500)
        })

        $('.yarazdelil-play__overlay').click(function () {
            $('.yarazdelil-play__popup iframe').attr('src', $('.yarazdelil-play__popup iframe').attr('src'));
            $('.yarazdelil-play__popup, .yarazdelil-play__overlay').fadeOut();
        })
    })
}()
