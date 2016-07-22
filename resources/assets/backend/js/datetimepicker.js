(
    function($, window, document) {
        $(document).ready(function() {
            $('[data-datepicker]').datetimepicker({ format: 'D-MM-Y', minDate: '1920-01-01', maxDate: moment()});
        });
    })(jQuery, window, document);