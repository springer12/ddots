(function ($, window, document) {
    $(document).ready(function () {
        var discipline_id = $('[data-discipline-id]').data('discipline-id');

        $('[data-select-students], [data-select-programming-languages]').select2({
            width: '100%'
        });

        $('[data-participant-select]').select2({
            width: '100%'
        });

        $('[data-group-select]').select2({
            width: '100%'
        });

        $('[ data-problem-select]').select2({
            width: '100%',
            ajax: {
                url: $('[data-get-problems-url]').data('get-problems-url'),
                dataType: 'json',
                quietMillis: 100,
                data: function (params) {
                    return {
                        discipline_id: discipline_id,
                        term: params.term,
                        page: params.page || 1
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.results, function (problem) {
                            if (!$('[data-problem-block-id=' + problem.id + ']').length) {
                                return {
                                    text: problem.name,
                                    id: problem.id
                                }
                            }
                        }),
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    }
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1
        });


        $('[ data-volume-select]').select2({
            width: '100%',
            ajax: {
                url: $('[data-get-volumes-url]').data('get-volumes-url'),
                dataType: 'json',
                quietMillis: 100,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page || 1
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.results, function (volume) {
                            return {
                                text: volume.name,
                                id: volume.id
                            }
                        }),
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    }
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1
        });
    });
})(jQuery, window, document);