module.exports = (function () {
    $(document).ready(function () {
        //регистрация групп
        $('.group-register').select2({
            placeholder: "Выберите клан",
            multiply: true,
            language: {
                noResults: function (params) {
                    return "Ничего не найдено :(";
                },
                maximumSelected: function (e) {
                    return "Можно выбрать только один клан";
                }
            },
            maximumSelectionLength: 1,
            minimumInputLength: 0
        })
    })
})();



