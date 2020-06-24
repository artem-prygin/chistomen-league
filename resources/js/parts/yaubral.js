module.exports = function () {
    $(document).ready(function () {
        $('.yaubral-moderation__ok').click(function () {
            $(`td[data-id=${$(this).attr('data-id')}] span`).removeClass().addClass('green').html('Принято');
            $.ajax({
                url: '/yaubral/postConfirm',
                type: 'post',
                data: $(this).parent('form').serialize(),
                success: function () {
                    $('.yaubral-getWinner').fadeIn().css('display', 'block');
                }
            })
        })

        $('.yaubral-moderation__delete').click(function () {
            $(`td[data-id=${$(this).attr('data-id')}] span`).removeClass().addClass('red').html('Отклонено');
            let data = $(this).parent('form').serialize();
            $.ajax({
                url: '/yaubral/postDecline',
                type: 'post',
                data,
                success: function () {
                    return;
                }
            })
        })

        $('.yaubral-getWinner').click(function () {
            if(confirm('Точно провести розыгрыш?')) {
                let data = $('.getWinner').serialize();
                $('.yaubral-loading').fadeIn();
                setTimeout(function () {
                    $('.yaubral-loading').hide();
                },2500)
                setTimeout(function () {
                    $.ajax({
                        url: '/yaubral/getWinner',
                        type: 'post',
                        data,
                        success: function (res) {
                            $('.yaubral-winner').html(
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
                            $('.yaubral-getWinner').remove();
                            $('.lightgreen').removeClass('lightgreen');
                            $(`tr[data-id=${res.id}]`).addClass('lightgreen');
                        }
                    })
                },2500)
            }
        })


        $('.yaubral-changeVideo').click(function () {
            $(this).hide();
            $('.yaubral')
        });
    })
}()
