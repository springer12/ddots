(
    function ($) {

        /**
         * Wysiwyg widget
         * @todo may be use some data-* config options
         * @todo remove immediate creation for all widgets and use createAll in main.js
         */
        $.widget('wysiwyg', function (options) {
            var self = $(this);
            if (!CKEDITOR) {
                throw new Error("[widget::wysiwyg] CKEDITOR is required for this widget");
            }
            CKEDITOR.replace(this,{filebrowserUploadUrl: options.uploadUrl});
        });
    }
)(jQuery);