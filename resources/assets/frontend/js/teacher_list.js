(function ($, window, document) {
    if (!$('[data-requests-forbidden]').length) {
        $('[data-add-teacher-button]').click(function (e) {
            var $this = $(this);
            $this.prop('disabled', true);
            $.ajax($this.data('add-teacher-url')).success(function (response) {
                    $this.hide();
                    $('#teacher_' + $this.data('teacher-id') + '.btn-success').show();
                    if (response.remainingRequests == 0) {
                        $('[data-modal-text]').text('You have expended your allowed requests');
                        $('[data-modal]').modal('show');
                        $('[data-teacher-id]').off('click');
                        $('[data-teacher-id]').prop('disabled', true);
                    }
            });
        });
    }
})(jQuery, window, document);