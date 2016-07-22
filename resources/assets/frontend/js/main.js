(
    function($, window, document) {
        $(document).ready(function() {
            $(':checkbox').checkboxpicker();
            $('[data-datepicker]').datetimepicker({ format: 'D-M-Y', minDate: '1920-01-01', maxDate: moment()});
            $('[data-language-selector]').click(function() {
                $('input[name=programming_language]').val($(this).data('id'));
                $('[data-language-selector-button]').text($(this).text());
            });
        });
    })(jQuery, window, document);
