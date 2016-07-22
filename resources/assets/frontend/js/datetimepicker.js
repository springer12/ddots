(
    function($, window, document) {
        $(document).ready(function() {
            $('[data-datepicker]').datetimepicker({ format: 'D-MM-Y', minDate: '1920-01-01', maxDate: moment()});
            $('[data-start-datepicker]').datetimepicker({format: 'Y-MM-DD H:mm:ss'});
            $('[data-end-datepicker]').datetimepicker({format: 'Y-MM-DD H:mm:ss'});
        });
    })(jQuery, window, document);
