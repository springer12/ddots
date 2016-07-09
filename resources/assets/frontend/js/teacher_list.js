(function ($, window, document) {
    if (!$('[data-requests-forbidden]').length) {
        $('[data-add-teacher-button]').click(function (e) {
            var $this = $(this);
            $this.prop('disabled', true);
            $.ajax($this.data('add-teacher-url')).success(function (response) {
                if (response.error !== true) {
                    $this.hide();
                    $('#teacher_' + $this.data('teacher-id') + '.btn-success').show();
                    if (response.remainingRequests == 0) {
                        window.alert('no more'); //@todo: alert???!!! only modal bootstrap dialogs
                        $('[data-teacher-id]').off('click');
                        $('[data-teacher-id]').prop('disabled', true);
                    }
                }
            });
        });
    }
})(jQuery, window, document);