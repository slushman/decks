/**
 * Shows/hides post format metaboxes based on the selected format.
 */
( function() {

	'use strict';

	var buttons, len, box, checked, valid;

	buttons = document.querySelectorAll( '.bg-type' );
	if ( ! buttons ) { return; }

	len = buttons.length;
	if ( 0 >= len ) { return; }

	/**
	 * Shows the correct post format metabox and hides the others.
	 */
	function showFormat() {

		var others = document.querySelectorAll( '.bg-fields:not( #fields-' + this.value + ' )' );
		var field = document.querySelector( '#fields-' + this.value );
		var otherslen = others.length;

		if ( 0 < otherslen ) {

			for ( var j = 0; j < otherslen; j++ ) {

				others[j].style.display = 'none';

			}

		}

		field.style.display = '';

	}

	for ( var i = 0; i < len; i++ ) {

		var button = buttons[i];

		/**
		 * Hide all field groups.
		 */
		if ( 'none' !== button.value ) {

			var field = document.querySelector( '#fields-' + button.value );

			if ( ! button.checked ) {

				field.style.display = 'none';

			}

		}

		button.addEventListener( 'click', showFormat );

	}

})();
