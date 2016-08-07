(function ($, window, document) {

    $(document).ready(function () {
        $('[data-select-volume]').select2({
            tags: true,
            width: '100%'
        });

        $('[data-select-subdomain], [data-select-students]').select2({
            width: '100%'
        });

        $('[data-select-owner]').select2({
            width: '100%',
            placeholder: 'Select owner',

            ajax: {
                url: $('[data-teacher-search-url]').data('teacher-search-url'),
                dataType: 'json',
                quietMillis: 100,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page || 1,
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.results, function (teacher) {
                            return {
                                text: teacher.name,
                                id: teacher.id
                            }
                        }),
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    }
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 1,
        })
            .on('change', function(e) {
                console.log($('[data-get-students-url]').data('get-students-url'));
                $.ajax($('[data-get-students-url]').data('get-students-url'), {
                    method: 'get',
                    data: {
                        teacher_id: $('[data-select-owner] :selected').val()
                    }
                }).done(function(response) {
                    $('[ data-select-students]').find('option').remove();

                    $.each(response.result, function(id, student) {
                        console.log(student);
                        $('[ data-select-students]').append('<option value="' + student['id'] + '">' + student['name'] + '</option>');
                    });
                });
            });

        $('[data-role-select]').change(function () {
            if ($('[data-role-select] option[data-teacher-option]:selected').length) {
                $('[data-subdomain-select]').show();
            } else {
                $('[data-subdomain-select]').hide();
            }
        });

        $('[data-select-programming-languages]').select2({
            width: '100%'
        });
    });
})(jQuery, window, document);