(
    function ($, window, document) {

        $(document).ready(function () {
            $('[data-select-volume]').select2({
                tags: true,
                width: '100%'
            });
            $('[data-select-subdomain]').select2({
                width: '100%'
            });
        });
    }
)(jQuery, window, document);