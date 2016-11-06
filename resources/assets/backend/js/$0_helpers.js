(
    function ($) {

        /**
         * Check if value is array
         * @param value
         * @returns {boolean}
         */
        var isArray = (
            function () {
                if (!isFunction(Array.isArray)) {
                    return function (value) {
                        return Object.prototype.toString.call(value) === '[object Array]';
                    };
                }
                return Array.isArray;
            }
        )();

        /**
         * Check if value is integer
         * @param value
         * @returns {boolean}
         */
        var isInteger = (
            function () {
                if (!isFunction(Number.isInteger)) {
                    return function (value) {
                        return typeof value === "number" &&
                               isFinite(value) &&
                               Math.floor(value) === value;
                    };
                }
                return Number.isInteger;
            }
        )();

        $.extend(
            {
                isArray: isArray,
                isInteger: isInteger,
                isObject: isObject,
                isString: isString,
                isNotEmptyString: isNotEmptyString,
                isFnction: isFunction,
                isDate: isDate,
                strval: strval,
                ucfirst: ucfirst,
                lcfirst: lcfirst,
                snake: snake,
                studly: studly,
                escapeRegEx: escapeRegEx,
                getRegex: getRegex,
                highlight: highlight,
                value: value,
                getURLParameters: getURLParameters
            }
        );
        $.fn.extend(
            {
                chVal: chVal,
                dataPrefix: dataPrefix
            }
        );

        /**
         * Check if value is object
         * @param value
         * @returns {boolean}
         */
        function isObject(value) {
            // http://jsperf.com/isobject4
            return value !== null && typeof value === 'object';
        }

        /**
         * Check if value is string
         * @param value
         * @returns {boolean}
         */
        function isString(value) {
            return typeof value === 'string';
        }

        /**
         * Check if value is string and not empty
         * @param value
         * @returns {boolean}
         */
        function isNotEmptyString(value) {
            return isString(value) && value != '';
        }

        /**
         * Check if value is function
         * @param value
         * @returns {boolean}
         */
        function isFunction(value) {
            return typeof value === 'function';
        }

        /**
         * Check if value is Date
         * @param value
         * @returns {boolean}
         */
        function isDate(value) {
            return Object.prototype.toString.call(value) === '[object Date]';
        }

        /**
         * Make value string
         * @param value
         * @returns {string}
         */
        function strval(value) {
            return "" + value;
        }

        /**
         * Make first character upper-cased
         * @param {string} str
         * @returns {string}
         */
        function ucfirst(str) {
            str = strval(str);
            return str.charAt(0).toUpperCase() + str.substr(1);
        }

        /**
         * Make first character lower-cased
         * @param {string} str
         * @returns {string}
         */
        function lcfirst(str) {
            str = strval(str);
            return str.charAt(0).toLowerCase() + str.substr(1);
        }

        /**
         * Make string snake-cased
         * @param {string} str
         * @param {string} delimiter, '_' by default
         * @returns {string}
         */
        function snake(str, delimiter) {
            delimiter = strval(delimiter || '_');
            return lcfirst(str).replace(/([A-Z])/, delimiter + '$1').toLowerCase();
        }

        /**
         * Make string studly-cased
         * @param {string} str
         * @param {boolean} ucf
         * @returns {string}
         */
        function studly(str, ucf) {
            str = strval(str).toLowerCase().replace(
                /([_-]+.)/, function (replace, found) {
                    return found[found.length - 1].toUpperCase();
                }
            );
            return (
                ucf ? ucfirst(str) : str
            );
        }

        /**
         * Escape string for regular expression
         * @param {string} str
         * @returns {string}
         */
        function escapeRegEx(str) {
            return strval(str).replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
        }

        /**
         * Convert patterns to RegExp object
         * @param {array|string} patterns
         * @param {boolean} caseSensitive
         * @param {boolean} wordsOnly
         * @returns {RegExp}
         */
        function getRegex(patterns, caseSensitive, wordsOnly) {
            var escapedPatterns = [], regexStr;
            patterns = isArray(patterns) ? patterns : [patterns];

            for (var i = 0, pattern; pattern = patterns[i]; i++) {
                escapedPatterns.push(escapeRegEx(pattern));
            }

            regexStr = wordsOnly ? "\\b(" + escapedPatterns.join("|") + ")\\b" : "(" + escapedPatterns.join("|") + ")";
            return caseSensitive ? new RegExp(regexStr) : new RegExp(regexStr, "i");
        }

        /**
         * Highlight pattern(s) inside text nodes
         * @param {object} o
         */
        function highlight(o) {
            var regex;
            var defaults = {
                node: null,
                pattern: null,
                tagName: "strong",
                className: null,
                wordsOnly: false,
                caseSensitive: false
            };
            o = $.extend({}, defaults, o);
            if (!o.node || !o.pattern) {
                return;
            }
            o.pattern = isArray(o.pattern) ? o.pattern : [o.pattern];
            regex = getRegex(o.pattern, o.caseSensitive, o.wordsOnly);
            traverse(o.node, hightlightTextNode);
            function hightlightTextNode(textNode) {
                var match, patternNode, wrapperNode;
                if (match = regex.exec(textNode.data)) {
                    wrapperNode = document.createElement(o.tagName);
                    o.className && (
                        wrapperNode.className = o.className
                    );
                    patternNode = textNode.splitText(match.index);
                    patternNode.splitText(match[0].length);
                    wrapperNode.appendChild(patternNode.cloneNode(true));
                    textNode.parentNode.replaceChild(wrapperNode, patternNode);
                }
                return !!match;
            }

            function traverse(el, hightlightTextNode) {
                var childNode, TEXT_NODE_TYPE = 3;
                for (var i = 0; i < el.childNodes.length; i++) {
                    childNode = el.childNodes[i];
                    if (childNode.nodeType === TEXT_NODE_TYPE) {
                        i += hightlightTextNode(childNode) ? 1 : 0;
                    } else {
                        traverse(childNode, hightlightTextNode);
                    }
                }
            }
        }

        /**
         * -------------------- *
         * jQuery.fn extensions *
         * -------------------- *
         */

        /**
         * Set value to field with change event
         * @param value mixed
         */
        function chVal(value) {
            this.val(value).trigger('change');
        }

        /**
         * Get values from data prefixed
         * @param prefix
         * @returns {object}
         */
        function dataPrefix(prefix) {
            var data = this.data(),
                filtered = {},
                filter = new RegExp('^' + prefix),
                key, value;
            for (var i in data) {
                if (data.hasOwnProperty(i)) {
                    if (i == prefix) {
                        value = data[i];
                        filtered[i] = value;
                    } else if (i.search(filter) != -1) {
                        key = lcfirst(i.replace(filter, ''));
                        value = data[i];
                        filtered[key] = value;
                    }
                }
            }

            return filtered;
        }

        function value(val) {
            return isFunction(val) ? val() : val;
        }

        function getURLParameters(url)
        {

            var result = {};
            var searchIndex = url.indexOf("?");
            if (searchIndex == -1 ) return result;
            var sPageURL = url.substring(searchIndex +1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++)
            {
                var sParameterName = sURLVariables[i].split('=');
                result[sParameterName[0]] = sParameterName[1];
            }
            return result;
        }
    }
)(jQuery);