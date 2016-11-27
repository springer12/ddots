(function ($, window, document) {
    $(document).ready(function () {
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

        function appendProblem(id, name, points, review, time_penalty) {
            if (!$('[data-problem-block-id=' + id + ']').length) {
                problems_elem.append(Mustache.render(element_template, {
                    name: name,
                    id: id,
                    element: 'problem',
                    type_problem: 1,
                    points: points,
                    review: review,
                    time_penalty: time_penalty
                }));
            }
        }

        $.each(problems_elem.data(), function (id, name) {
            if ($.isNumeric(id)) {
                appendProblem(id, name, problems_elem.data(id + '-points'), problems_elem.data(id + '-review'), problems_elem.data(id + '-time-penalty'));
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
                appendProblem(elem.val(), elem.text(), 0, 0, 20)
                elem.remove();
            }
        }

        $(document.body).on('change', '[data-problem-select]', function () {
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
                    appendProblem(v.id, v.name, 0, 0, 20);
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