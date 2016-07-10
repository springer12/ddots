(function ($, window, document) {
    $('[data-confirm]').click(function (e) {
        var $this = $(this);
        $('[data-student-id=' + $this.data('student-id') + ']').prop('disabled', true);
        $.ajax($this.data('url')).success(function (response) {
            if (response.error !== true) {
                $('[data-student-id=' + $this.data('student-id') + ']').hide();
                $('[data-edit-student-id=' + $this.data('student-id') + ']').show();
            }
        });
    });

    $('[data-decline]').click(function (e) {
        var $this = $(this);
        $('[data-student-id=' + $this.data('student-id') + ']').prop('disabled', true);
        $.ajax($this.data('url')).success(function (response) {
            if (response.error !== true) {
                $('[data-student-row-id=' + $this.data('student-id') + ']').remove();
            }
        });
    });
})(jQuery, window, document);