(
    function ($, window, document) {

        $(document).ready(function () {

            $("div.flash-message").delay(3000).slideUp(300);

            /**
             * Constants
             */
            var TIME_FORMAT_INTERNAL = 'YYYY-MM-DD HH:mm:ss',
                DATE_FORMAT_DEFAULT = 'DD/MM/YYYY',
                DATE_MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                DATE_MONTHS_SHORT = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
                URI_KEYWORD_RELOAD = 'reload',
                URI_TYPE_PREFIX_AJAX = 'ajax://',
                URI_KEYWORD_BACK = 'back',
                URI_KEYWORD_BACK_TO_TOP = 'back_to_top',
                LINK_KEYWORD_PROXY = 'proxy',
                AJAX_RESPONSE_FORMAT = 'json',
                AJAX_RESPONSE_KEY_STATUS = 'success',
                AJAX_RESPONSE_KEY_REDIRECT = 'redirect',
                AJAX_RESPONSE_KEY_ERRORS = 'errors',
                AJAX_RESPONSE_KEY_MESSAGES = 'messages',
                FORM_ROLE_AJAX = 'ajax-form',
                FORM_ERROR_HOLDER = 'help-block',
                CONFIRM_TEMPLATE = '<div class="modal fade {class}">'
                    + '<div class="modal-dialog">'
                    + '<div class="modal-content">'
                    + '<div class="modal-header">'
                    + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    + '</div>'
                    + '<div class="modal-body">'
                    + '<h4 class="modal-title">{message}</h4>'
                    + '</div>'
                    + '<div class="modal-footer">'
                    + '<a type="button" class="btn btn-warning {btnCancelClass}" data-dismiss="modal"><span class="fa fa-angle-left"></span> {btnCancelLabel}</a>'
                    + '<a data-link="" href="{btnOkHref}" class="btn btn-primary {btnOkClass}">{btnOkLabel} <span class="fa fa-angle-right"></span></a>'
                    + '</div>'
                    + '</div><!-- /.modal-content -->'
                    + '</div><!-- /.modal-dialog -->'
                    + '</div><!-- /.modal -->';

            /**
             * Modal tpl
             */
            function prepareModalTpl(data, tpl) {
                tpl = tpl || MODAL_TEMPLATE;
                function renderer(replace, key) {
                    if (data[key] !== undefined) {
                        return data[key];
                    }
                    return data[key] || '';
                }
                return $(tpl.replace(/\{(\w+)\}/g, renderer));
            }

            /**
             * Confirm modal
             */
            function modalConfirm(config) {
                var data = {
                        'class': config['class'] || '',
                        'title': config['title'] || '',
                        'message': config['message'] || 'Are you sure?',
                        'btnOkHref': config['btnOkHref'] || URI_KEYWORD_RELOAD,
                        'btnOkLabel': config['btnOkLabel'] || 'Ok',
                        'btnOkClass': config['btnOkClass'] || '',
                        'btnCancelLabel': config['btnCancelLabel'] || 'Cancel',
                        'btnCancelClass': config['btnCancelClass'] || ''
                    },
                    template = config['template'] || CONFIRM_TEMPLATE,
                    modal = prepareModalTpl(data, template);
                modal.modal({backdrop: 'static', keyboard: true, show: false});
                return modal.data('bs.modal');
            }
            $('[data-toggle="confirmation"]').click(function (e) {
                var $this = $(this),
                    modal = $this.data('modalConfirm');
                if (!modal) {
                    modal = modalConfirm($this.data());
                    $this.data('modalConfirm', modal);
                }

                modal.show();

                return e.preventDefault();
            });

        });
    }
)(jQuery, window, document);