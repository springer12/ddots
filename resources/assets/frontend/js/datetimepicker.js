(
    function($, window, document) {
        $(document).ready(function() {
            if ( $('[data-datepicker]').prop('type') != 'date' ) {
                $('[data-datepicker]').datetimepicker({ format: 'Y-MM-DD', minDate: '1920-01-01', maxDate: moment().subtract(4, 'y')});
            } else {
                $('[data-datepicker]').attr('min', '1920-01-01');
                $('[data-datepicker]').attr('max', moment().subtract(4, 'y').format('Y-MM-DD'));
            }

            if ( $('[data-start-datepicker]').prop('type') != 'datetime' ) {
                $('[data-start-datepicker]').datetimepicker({format: 'Y-MM-DD H:mm:ss'});
                $('[data-end-datepicker]').datetimepicker({format: 'Y-MM-DD H:mm:ss'});
            }

        });
    })(jQuery, window, document);
