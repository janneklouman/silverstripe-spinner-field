(function($) {

    $.entwine( 'ss', function( $ ) {

        $( '.spinner-field' ).entwine( {

            onmatch: function() {
                SpinnerField.init( $SpinnerOptions, $Name );
            }

        } );

    } );

})(jQuery);