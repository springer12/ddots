(function ($, window, document) {
    $(document).ready(function () {
        $('[data-select-students], [data-select-programming-languages]').select2({
            width: '100%'
        });
        $('[data-participant-select]').select2({
            width: '100%',
            placeholder: 'Select a participant'
        });
        $('[data-group-select]').select2({
            width: '100%',
            placeholder: 'Select a group'
        });
    });
})(jQuery, window, document);