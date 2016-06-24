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
     * @type {*|HTMLElement}
     * @private
     */
    var _$fieldElement;

    /**
     * Initialize component.
     *
     * @param options
     * @param name
     */
    var init = function( options, name ) {

        // Override options if passed through init function.
        options = JSON.parse( options ) || {};
        for ( var key in _options ) {
            if ( _options.hasOwnProperty( key ) && options.hasOwnProperty( key ) )
                _options[key] = options[key];
        }

        setFieldElement( $( 'input[name="' + name + '"]' ) );
        applySpinner();

    };

    /**
     * @param $element
     * @private
     */
    var setFieldElement = function($element) {
        _$fieldElement = $element;
    };

    /**
     * Initialize the jQuery UI Spinner.
     */
    var applySpinner = function() {
        _$fieldElement.spinner(_options);
    };

    /**
     * Returns the jQuery element.
     *
     * @returns {*|HTMLElement}
     */
    var getSpinner = function() {
        return _$fieldElement;
    };

    return {
        init: init,
        getSpinner: getSpinner
    }

})(SpinnerField || {}, jQuery);