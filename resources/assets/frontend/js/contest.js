(function ($, window, document) {
    $(document).ready(function () {
        // $('[data-participants]').on('click', '[data-participant]', function () {
        //     var $this = $(this);
        //     $('[data-students]').append('<li role="presentation"><a data-student data-student-id="' + $this.data('student-id') + '">' + $this.text() + '</a></li>');
        //     $this.parent().remove();
        // });
        // $('[data-students]').on('click', '[data-student]', function () {
        //     var $this = $(this);
        //     $('[data-participants]').append('<li><a data-participant data-student-id="' + $this.data('student-id') + '">' + $this.text() + '</a><input type="hidden" name="participants[]" value="' + $this.data('student-id') + '" /></li>');
        //     $this.parent().remove();
        // });
        //
        // $('[data-included-problems]').on('click', '[data-included-problem]', function () {
        //     var $this = $(this);
        //     $('[data-unincluded-problems]').append('<li role="presentation"><a data-unincluded-problem data-problem-id="' + $this.data('problem-id') + '">' + $this.text() + '</a></li>');
        //     $this.parent().remove();
        // });
        // $('[data-unincluded-problems]').on('click', '[data-unincluded-problem]', function () {
        //     var $this = $(this);
        //     $('[data-included-problems]').append('<li><a data-included-problem data-problem-id="' + $this.data('problem-id') + '">' + $this.text() + '</a><input type="hidden" name="problems[]" value="' + $this.data('problem-id') + '" /><input type="number" name="problem_points[' + $this.data('problem-id') + ']" value="0"/></li>');
        //     $this.parent().remove();
        // });

        var participants_elem = $('[data-participants]');
        var participant_template = $('#participant_block').html();
        Mustache.parse(participant_template);
        $.each(participants_elem.data(), function (id, name) {
            if ($.isNumeric(id)) {
                participants_elem.append(Mustache.render(participant_template, {
                    name: name,
                    id: id
                }));
            }
        });

        function addParticipant(elem) {
            if (elem.length) {
                participants_elem.append(Mustache.render(participant_template, {
                    name: elem.text(),
                    id: elem.data('student-id')
                }));
                elem.remove();
            }
        }

        $('[data-participants-select]').change(function () {
            addParticipant($('[data-participants-select] > :selected'));
        });

        $(participants_elem).on('click', '[data-remove-participant-id]', function () {
            var $this = $(this);
            $('[data-participants-select]').append('<option data-student-id=' + $this.data('remove-participant-id') + '>' + $this.data('remove-participant-name') + '</option>')
            $('[data-participant-block-id=' + $this.data('remove-participant-id') + ']').remove();
        });

        $('[data-group-select]').change(function () {
            var elem = $('[data-group-select] > :selected');
            $.each(elem.data('user-ids'), function (k, v) {
                addParticipant($('[data-student-id=' + v + ']'));
            });
        })
    });
})(jQuery, window, document);