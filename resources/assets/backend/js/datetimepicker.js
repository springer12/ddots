(
    function($, window, document) {
        $(document).ready(function() {
            $('[data-datepicker]').datetimepicker({ format: 'D-MM-Y', minDate: '1920-01-01', maxDate: moment().subtract(4, 'y')});
        });
    })(jQuery, window, document);