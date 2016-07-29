(function ($, window, document) {

    $(document).ready(function () {
        $('[data-select-volume]').select2({
            tags: true,
            width: '100%'
        });
        $('[data-select-subdomain]').select2({
            width: '100%'
        });

        $('[data-select-participants]').select2({
            width: '100%',
            placeholder: 'Select students',

            ajax: {
                url: $('[data-student-search-url]').data('student-search-url'),
                dataType: 'json',
                quietMillis: 100,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page || 1,
                    }
                },
                processResults: function (data, params) {
                    console.log(data);
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.results, function (student) {
                            return {
                                text: student.name,
                                id: student.id
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
        });

        $('[data-role-select]').change(function () {
            if ($('[data-role-select] option[data-teacher-option]:selected').length) {
                $('[data-subdomain-select]').show();
            } else {
                $('[data-subdomain-select]').hide();
            }
        })
    });
})(jQuery, window, document);