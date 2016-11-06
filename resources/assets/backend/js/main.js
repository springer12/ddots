(
    function ($, window, document) {
        $(document).ready(function () {
            $("div.flash-message").delay(3000).slideUp(300);
            $.widget.createAll();
        });
    }
)(jQuery, window, document);