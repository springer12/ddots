(
    function($, window, document) {
        $(document).ready(function() {
            if($('#editor').length) {
                var editor = ace.edit('editor');
                editor.setTheme("ace/theme/monokai");
                editor.getSession().setTabSize(4);
                editor.getSession().setUseSoftTabs(true);
                editor.getSession().setUseWrapMode(true);
                editor.getSession().setMode("ace/mode/javascript");

                $('[data-programming-languages]').change(function(){
                    editor.getSession().setMode("ace/mode/" + $('[data-ace-mode]:selected').data('ace-mode'));
                });
            }

            $('[data-submit-solution]').submit(function (e) {
                var code = editor.getValue();
                if(code.length) {
                    $('input[name=solution_code]').val(code)
                }
            })
        });
    })(jQuery, window, document);