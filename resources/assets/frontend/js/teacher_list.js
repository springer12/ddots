(function ($, window, document) {
    if (!$('[data-requests-forbidden]').length) {
        $('[data-add-teacher-button]').click(function (e) {
            var $this = $(this);
            $this.prop('disabled', true);
            $.ajax($this.data('add-teacher-url'), {
                success: function (response) {
                    $this.hide();
                    $('#teacher_' + $this.data('teacher-id') + '.btn-success').show();
                    if (response.remainingRequests == 0) {
                        var $button = $('[data-teacher-id]');
                        $('[data-modal-text]').text($button.data('error-text'));//@todo
                        $('[data-modal]').modal('show');
                        $button.off('click');
                        $button.prop('disabled', true);
                    }
                }
            });
        });
    }
})(jQuery, window, document);