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

    $('[data-included-problems]').on('click', '[data-included-problem]', function () {
        var $this = $(this);
        $('[data-unincluded-problems]').append('<li role="presentation"><a data-unincluded-problem data-problem-id="' + $this.data('problem-id') + '">' + $this.text() + '</a></li>');
        $this.parent().remove();
    });
    $('[data-unincluded-problems]').on('click', '[data-unincluded-problem]', function () {
        var $this = $(this);
        $('[data-included-problems]').append('<li><a data-included-problem data-problem-id="' + $this.data('problem-id') + '">' + $this.text() + '</a><input type="hidden" name="problems[]" value="' + $this.data('problem-id') + '" /><input type="number" name="problem_points[' + $this.data('problem-id') + ']" value="0"/></li>');
        $this.parent().remove();
    });
})(jQuery, window, document);