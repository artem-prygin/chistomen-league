module.exports = function () {
    $(document).ready(function () {

        /*deleted images logic*/
        let idArr = [];
        $('.post-image__close').click(function () {
            let id = $(this).attr('data-image');
            let ext = $(this).attr('data-extension');
            idArr.push(id+'.'+ext)
            $(`.post-image[data-image=${id}]`).remove();
            $('#deleted-images').val(idArr);
            $('.post-images__left').html(+$('.post-images__left').html() + 1)
            $('input[name="images-left"]').val(+$('input[name="images-left"]').val() + 1)
        });

        /*submit btns*/
        $('#post-edit').click(function () {
            $('.post-edit__form').submit();
        });

        $('#post-delete').click(function () {
            if(confirm('Точно удалить пост?')) {
                $('#post-delete__form').submit();
            }
        })
    })
}()
