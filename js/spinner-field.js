"use strict";

( function( $ ) {

    $.entwine( 'ss', function( $ ) {

        $( '.spinner-field' ).entwine( {

            onmatch: function() {

                var $this   = $( this );
                var options = JSON.parse( $this.attr( 'data-spinner-options' ) );

                $this.spinner(options);

            }

        } );

    } );

})( jQuery );