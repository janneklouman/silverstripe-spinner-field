"use strict";

( function( $ ) {

    $.entwine( 'ss', function( $ ) {
        $( '.spinner-field' ).entwine( {

            onmatch: function() {

                var $this     = $(this);
                var options   = $this.attr( 'data-spinner-options' );
                var fieldName = $this.attr( 'name' );

                // Pass options as a string (parsed to JSON in spinner-field.js)
                SpinnerField.init( options, fieldName );
                
            }

        } );

    } );

})( jQuery );