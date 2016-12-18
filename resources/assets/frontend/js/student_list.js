(function ($, window, document) {
    $('[data-confirm]').click(function () {
        var $this = $(this);
        $('[data-student-id=' + $this.data('student-id') + ']').prop('disabled', true);
        $.ajax($this.data('url'), {
            success: function (response) {
                if (response.error !== true) {
                    $('[data-student-id=' + $this.data('student-id') + ']').hide();
                    $('[data-edit-student-id=' + $this.data('student-id') + ']').show();
                }
            }
        });
    });

    $('[data-decline]').click(function () {
        var $this = $(this);
        $('[data-student-id=' + $this.data('student-id') + ']').prop('disabled', true);
        $.ajax($this.data('url'), {
            success: function (response) {
                if (response.error !== true) {
                    $('[data-student-row-id=' + $this.data('student-id') + ']').remove();
                }
            }
        });
    });

    $('[data-add-student]').click(function () {
        var $this = $(this);
        $this.off('click');
        $.ajax($this.data('url'), {
            success: function (response) {
                $this.hide();
            }
        });
    });
})(jQuery, window, document);