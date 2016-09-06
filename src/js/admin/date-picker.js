/**
 * Initialize the Jquery UI Date Picker
 *
 * Triggers from either entering the field or clicking the calendar icon.
 */
(function( $ ) {

	'use strict';

	$( function() {

		$( '[pick="date"]' ).datepicker();
		$( '.date-field-icon' ).on( 'click', function(){
			$( '[pick="date"]' ).datepicker( 'show' );
		});

	});

})( jQuery );
