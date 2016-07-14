(function ($, window, document) {
    $('[data-participants]').on('click', '[data-participant]', function () {
        var $this = $(this);
        $('[data-students]').append('<li role="presentation"><a data-student data-student-id="' + $this.data('student-id') + '">' + $this.text() + '</a></li>');
        $this.parent().remove();
    });
    $('[data-students]').on('click', '[data-student]', function () {
        var $this = $(this);
        $('[data-participants]').append('<li><a data-participant data-student-id="' + $this.data('student-id') + '">' + $this.text() + '</a><input type="hidden" name="participants[]" value="' + $this.data('student-id') + '" /></li>');
        $this.parent().remove();
    });
})(jQuery, window, document);