(
    function($, window, document) {
        $(document).ready(function() {
            $(':checkbox').checkboxpicker();
            $('[data-language-selector]').click(function() {
                $('input[name=programming_language]').val($(this).data('id'));
                $('[data-language-selector-button]').text($(this).text());
            });
        });
    })(jQuery, window, document);