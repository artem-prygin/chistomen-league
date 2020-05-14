module.exports = function () {
    $(document).ready(function () {
        $('.post-images__slider').owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            navText: ["<i class='fa fa-chevron-left post-arrow post-arrow__left'></i>", "<i class='fa fa-chevron-right post-arrow post-arrow__right'></i>"],
        })

        $('.post-block__img').owlCarousel({
            items: 1,
            loop: true,
            mouseDrag: false,
            touchDrag: false,
            pullDrag: false,
            nav: false,
            dots: false,
        })
    })
}()
