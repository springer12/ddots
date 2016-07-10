(
    function ($, window, document) {

        $(document).ready(function () {
            $(".select_volume").select2({
                tags: true,
                width: '100%'
            })
        });
    }
)(jQuery, window, document);