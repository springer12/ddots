(function ($, window, document) {
    $(document).ready(function () {
        $('[data-select-students]').select2({
            width: '100%'
        });
        $('[data-select-programming-languages]').select2({
            width: '100%'
        });
    });
})(jQuery, window, document);