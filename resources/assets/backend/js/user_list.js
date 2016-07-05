(
    function($, window, document) {
        $(document).ready(function() {
            $(':checkbox').checkboxpicker();
            $('[data-datepicker]').datepicker({startView: "decade", startDate: "-90y", endDate: "0d"});
            $('[data-language-selector]').click(function() {
                $('input[name=programming_language]').val($(this).data('id'));
                $('[data-language-selector-button]').text($(this).text());
            });
        });
    })(jQuery, window, document);