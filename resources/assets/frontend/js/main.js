(
    function($, window, document) {
        $(document).ready(function() {
            $(':checkbox').checkboxpicker();
            $('[data-datepicker]').datepicker({startView: "decade", startDate: "-90y", endDate: "0d"});
            $('[data-language-selector]').click(function() {
                $('input[name=programming_language]').val($(this).data('id'));
                $('[data-language-selector-button]').text($(this).text());
            });


            if(!$('[data-requests-forbidden]').length) {
                $('[data-teacher-id]').click(function(e) {
                    var button = $(this);
                    button.prop('disabled', true);
                    $.ajax($('[data-post-url]').val(), {
                        method: 'POST',
                        data: {'id': button.data('teacher-id'), '_token': $('[data-x-csrf]').val()}
                    }).success(function(result) {
                        if(result > -1) {
                            button.hide();
                            $('#teacher_' + button.data('teacher-id') + '.btn-success').show();
                            if(result == 0) {
                                window.alert('no more'); //@todo: alert???!!! only modal bootstrap dialogs
                                $('[data-teacher-id]').off('click');
                                $('[data-teacher-id]').prop('disabled', true);
                            }
                        }
                    });
                });
            }
        });
    })(jQuery, window, document);