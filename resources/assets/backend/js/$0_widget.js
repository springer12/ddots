(
    function ($) {

        /**
         * Collection of widgets.
         *
         * @type {Object}
         */
        var collection = {};

        $.extend(
            {
                widget: widget
            }
        );

        /**
         * Create all widgets
         */
        widget.createAll = function () {
            for (var name in collection) {
                if (collection.hasOwnProperty(name) && !collection[name].created) {
                    createWidget(name, collection[name].creator);
                    collection[name].created = true;
                }
            }
        };

        /**
         * Create widget with specified name
         *
         * @param {String} name
         */
        widget.create = function (name) {
            if (!collection.hasOwnProperty(name)) {
                throw new Error("[widget] Widget named as '" + name + "' was not found");
            }
            if (collection[name].created) {
                console.warn("[widget] Widget named as '" + name + "' has already been created");
                return;
            }
            createWidget(name, collection[name].creator);
            collection[name].created = true;
        };

        /**
         * Create widget
         * @param {String} name
         * @param {Function} creator
         */
        function createWidget(name, creator) {
            $('[data-' + $.snake(name, '-') + ']').each(
                function () {
                    creator.call(this, $(this).dataPrefix($.studly(name, false)));
                }
            );
        }

        /**
         * Short reference to create some widgets
         * @param {String} name
         * @param {Function} creator
         * @returns {Function}
         */
        function widget(name, creator) {
            if (!$.isNotEmptyString(name) || !$.isFunction(creator)) {
                throw new Error("[widget] Widget should has name and creator function");
            }
            collection[name] = {
                'creator': creator,
                'created': false
            };

            return function() {
                widget.create(name);
            };
        }
    }
)(jQuery);