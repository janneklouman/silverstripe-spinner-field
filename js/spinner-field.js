"use strict";

/**
 * SpinnerField module for silverstripe spinner field.
 */
var SpinnerField = (function (SpinnerField, $) {

    /**
     * Default/available spinner options.
     *
     * @type {{}}
     * @private
     */
    var _options = {
         culture : null,
        disabled : false,
           icons : {
                down : 'ui-icon-triangle-1-s',
                  up : 'ui-icon-triangle-1-n'
           },
     incremental : true,
             max : null,
             min : null,
    numberFormat : null,
            page : 10,
            step : 1
    };

    /**
     * Initialize component.
     *
     * @param options
     * @param name
     */
    var init = function(options, name) {

        // Override options if passed through init function.
        options = JSON.parse(options) || {};
        for (var key in _options) {
            if (_options.hasOwnProperty(key) && options.hasOwnProperty(key))
                _options[key] = options[key];
        }

        $('#spinner-field-' + name).spinner(_options);

    };

    return {
        init: init
    }

})(SpinnerField || {}, jQuery);