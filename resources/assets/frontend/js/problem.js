(
    function($, window, document) {
        $(document).ready(function() {
            if($('#editor').length) {

                var editor = ace.edit('editor');
                editor.setOptions({
                    enableBasicAutocompletion: true,
                    enableLiveAutocompletion: true,
                    showInvisibles: true,
                    tabSize: 4,
                    wrap: true,
                    useSoftTabs: true,
                    theme: "ace/theme/monokai"
                });
                
                if($('[data-solution]').length) {
                    editor.getSession().setMode("ace/mode/" + $('[data-ace-mode]').data('ace-mode'));
                    editor.setReadOnly(true);
                }

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