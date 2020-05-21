module.exports = function () {
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
    })
}()
