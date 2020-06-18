module.exports = function () {
    $(document).ready(function () {
        $.fancybox.defaults.loop = true;
    })

    $('.yaubral-link a').click(function (e) {
        e.preventDefault();
    })
}()
