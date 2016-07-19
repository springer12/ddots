(
    function($, window, document) {
        $(document).ready(function() {
            if($('#editor').length) {
                var editor = ace.edit('editor');
                editor.setTheme("ace/theme/monokai");
                editor.getSession().setMode("ace/mode/javascript");
            }
            $('[data-submit-solution]').submit(function (e) {
                var code = editor.getValue();
                if(code.length) {
                    $('input[name=solution_code]').val(code)
                }
            })
        });
    })(jQuery, window, document);