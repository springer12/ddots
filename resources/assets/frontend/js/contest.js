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
        var problems_elem = $('[data-problems]');
        var element_template = $('[data-element-block]').html();
        Mustache.parse(element_template);
        $.each(participants_elem.data(), function (id, name) {
            if ($.isNumeric(id)) {
                appendParticipant(id, name);
            }
        });

        function appendParticipant(id, name) {
            participants_elem.append(Mustache.render(element_template, {
                name: name,
                id: id,
                element: 'participant',
                type_participant: 1
            }));
        }

        function appendProblem(id, name, points) {
            if (!$('[data-problem-block-id=' + id + ']').length) {
                problems_elem.append(Mustache.render(element_template, {
                    name: name,
                    id: id,
                    element: 'problem',
                    type_problem: 1,
                    points: points
                }));
            }
        }

        $.each(problems_elem.data(), function (id, name) {
            if ($.isNumeric(id)) {
                appendProblem(id, name, $('[data-' + id + '-points]').data(id + '-points'));
            }
        });

        function addParticipant(elem) {
            if (elem.length) {
                appendParticipant(elem.val(), elem.text());
                elem.remove();
            }
        }

        function addProblem(elem) {
            if (elem.length) {
                appendProblem(elem.val(), elem.text(), 0)
                elem.remove();
            }
        }

        $(document.body).on('change', '[data-problem-select]', function () {
            console.log($($(this).select2('data')[0].element));
            addProblem($($(this).select2('data')[0].element));
        });

        $(document.body).on('change', '[data-participant-select]', function () {
            addParticipant($($(this).select2('data')[0].element));
        });

        $(participants_elem).on('click', '[data-remove-participant-id]', function () {
            var $this = $(this);
            $('[data-participant-select]').append('<option value=' + $this.data('remove-participant-id') + '>' + $this.data('remove-participant-name') + '</option>')
            $('[data-participant-block-id=' + $this.data('remove-participant-id') + ']').remove();
        });

        $(problems_elem).on('click', '[data-remove-problem-id]', function () {
            var $this = $(this);
            $('[data-problem-block-id=' + $this.data('remove-problem-id') + ']').remove();
        });

        $(document.body).on('change', '[data-volume-select]', function () {
            $.ajax({
                method: 'GET',
                url: $('[data-get-problems-url]').data('get-problems-url'),
                data: {volume_id: $($(this).select2('data')[0].element).val()}
            }).success(function (response) {
                $.each(response, function (k, v) {
                    appendProblem(v.id, v.name, 0);
                });
            });
            $(this).val(null);
        });

        $(document.body).on('change', '[data-group-select]',
            function () {
                $.each($($(this).select2('data')[0].element).data('user-ids'), function (k, v) {
                    addParticipant($('[data-participant-select] > option[value=' + v + ']'));
                });
                $(this).val(null);
            })
    });
})(jQuery, window, document);