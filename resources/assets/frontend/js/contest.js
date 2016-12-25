(function ($, window, document) {
    $(document).ready(function () {
        var $participants_elem = $('[data-participants]');
        var $problems_elem = $('[data-problems]');
        var $element_template = $('[data-element-block]').html();
        var $acm = $('[data-acm-input]');
        var $show_max = $('[data-show-max-input]');
        var $standings = $('[data-standings-input]');
        var $problems_tab = $('[data-contest-problems-tab]');
        var $user_problems = $('[data-user-problems]');
        var $exam_input = $('[data-exam-input]');
        var $save_problems = $('[data-save-user-problems]');
        var $modal = $('[data-contest-user-modal]');
        var $problem_tables = $('[data-problems], [data-user-problems]');

        Mustache.parse($element_template);
        $.each($participants_elem.data(), function (id, name) {
            if ($.isNumeric(id)) {
                appendParticipant(id, name);
            }
        });

        function appendParticipant(id, name) {
            $participants_elem.append(Mustache.render($element_template, {
                name: name,
                id: id,
                element: 'participant',
                type_participant: 1
            }));
        }

        function appendProblem(id, name, points, review, time_penalty) {
            if (!$('[data-problem-block-id=' + id + ']').length || !$exam_input.length || $exam_input[0].checked) {
                if ($exam_input.length) {
                    ($exam_input[0].checked ? $user_problems : $problems_elem).append(Mustache.render($element_template, {
                        name: name,
                        id: id,
                        element: 'problem',
                        type_problem: 1,
                        points: points,
                        review: review,
                        time_penalty: time_penalty
                    }));
                } else {
                    $problems_elem.append(Mustache.render($element_template, {
                        name: name,
                        id: id,
                        element: 'problem',
                    }));
                }
            }
        }

        $.each($problems_elem.data(), function (id, name) {
            if ($.isNumeric(id)) {
                appendProblem(id, name, $problems_elem.data(id + '-points'), $problems_elem.data(id + '-review'), $problems_elem.data(id + '-time-penalty'));
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
                appendProblem(elem.val(), elem.text(), 0, 0, 20);
                elem.remove();
            }
        }

        $(document.body).on('change', '[data-problem-select]', function () {
            addProblem($($(this).select2('data')[0].element));
        });

        $(document.body).on('change', '[data-participant-select]', function () {
            addParticipant($($(this).select2('data')[0].element));
        });

        $participants_elem.on('click', '[data-remove-participant-id]', function () {
            var $this = $(this);
            $('[data-participant-select]').append('<option value=' + $this.data('remove-participant-id') + '>' + $this.data('remove-participant-name') + '</option>');
            $('[data-participant-block-id=' + $this.data('remove-participant-id') + ']').remove();
        });
        $problem_tables.on('click', '[data-remove-problem-id]', function () {
            var $this = $(this);
            $('[data-problem-block-id=' + $this.data('remove-problem-id') + ']').remove();
        });

        $participants_elem.on('click', '[data-edit-participant-id]', function () {
            $modal.modal();
            var user_id = $(this).data('edit-participant-id');
            $('[data-user-problems]').empty();
            var val = $('[data-user-problems-input-id=' + user_id + ']').val();
            if (val) {
                $.each($.parseJSON(val), function (k, v) {
                    appendProblem(k, v.name, v.max_points, v.review_required, v.time_penalty);
                });
            }

            $save_problems.data('user-id', user_id);
        });
        var $all_user_problems = $('[data-all-user-problems]');
        if ($all_user_problems.length) {
            var all_problems = $all_user_problems.data('all-user-problems');
            $.each(all_problems, function (k, v) {
                appendUserProblem(k, v);
            });
        }

        function appendUserProblem(user_id, data) {
            $('[data-user-problems-input-id=' + user_id + ']').remove();
            $('[data-user-problems-id=' + user_id + ']').append('<input data-user-problems-input-id="' + user_id + '" type="hidden" value=\'' + JSON.stringify(data) + '\' name="user_problems[' + user_id + ']"/>');
        }

        $save_problems.click(function () {
            $modal.modal('hide');
            var data = {};
            $.each($('[data-problem-block-id]'), function (k, v) {
                var id = $(v).data('problem-block-id');

                data[id] = {
                    max_points: $('input[name="points[' + id + ']"]').val(),
                    review_required: $('input[name="review_required[' + id + ']"]')[0].checked,
                    time_penalty: $('input[name="time_penalty[' + id + ']"]').val(),
                    name: $('[data-problem-' + id + '-name]').data('problem-' + id + '-name')
                }

            });
            appendUserProblem($save_problems.data('user-id'), data);
        });

        $(document.body).on('change', '[data-volume-select]', function () {
            $.ajax({
                method: 'GET',
                url: $('[data-get-problems-url]').data('get-problems-url'),
                data: {volume_id: $($(this).select2('data')[0].element).val()},
                success: function (response) {
                    $.each(response, function (k, v) {
                        appendProblem(v.id, v.name, 0, 0, 20);
                    });
                }
            });
            $(this).val(null);
        });

        $acm.on('change', function () {
            if (this.checked) {
                $show_max.attr('disabled', true);
                $show_max.prop('checked', false);
            } else {
                $show_max.attr('disabled', false);
            }
        });

        $exam_input.on('change', function () {
            if (this.checked) {
                $problems_tab.addClass('invisible');
                $standings.attr('disabled', true);
                $standings.prop('checked', false);

                $acm.attr('disabled', true);
                $acm.prop('checked', false);

                $show_max.attr('disabled', true);
                $show_max.prop('checked', false);

                $('[data-edit-participant-id]').removeClass('invisible');
            } else {
                $problems_tab.removeClass('invisible');
                $show_max.attr('disabled', false);
                $standings.attr('disabled', false);
                $acm.attr('disabled', false);

                $('[data-edit-participant-id]').addClass('invisible');
            }
        });

        $(document.body).on('change', '[data-group-select]',
            function () {
                $.each($($(this).select2('data')[0].element).data('user-ids'), function (k, v) {
                    addParticipant($('[data-participant-select] > option[value=' + v + ']'));
                });
                $(this).val(null);
            });
        $('[data-contest-save-input]').attr('disabled', false);
    });
})(jQuery, window, document);