/**
 * Adds/removes file or image to selected field.
 */
( function(){

	var fields = document.querySelectorAll( '.image-upload-field' );
	if ( ! fields ) { return; }

	var len = fields.length;
	if ( 0 >= len ) { return; }

	/**
	 * Opens the Media Library window.
	 * Sets the field value.
	 * Toggles the links.
	 *
	 * @todo 		Figure out how to get rid of jQuery "on" dependency here.
	 *
	 * @param 		object 		e 			The event object
	 */
	function openMediaLibraryChooser( e ) {

		e.preventDefault();

		var fileFrame, json, parent, field, remove, upload, preview;

		upload = this;
		parent = this.parentNode;
		field = parent.querySelector( '[type="hidden"]' );
		remove = parent.querySelector( '#remove-img' );
		preview = parent.querySelector( '.image-upload-preview' );

		if ( undefined !== fileFrame ) {

			fileFrame.open();
			return;

		}

		fileFrame = wp.media.frames.fileFrame = wp.media({
			button: {
				text: 'Choose Image',
			},
			frame: 'select',
			multiple: false,
			title: 'Choose image'
		});

		fileFrame.on( 'select', function(){ // must use jQuery here - TODO - explore options

			json = fileFrame.state().get( 'selection' ).first().toJSON(); // also jQuery

			if ( 0 >= json.id.length ) { return; }

			field.value = json.id;
			preview.style.backgroundImage = 'url( ' + json.sizes.thumbnail.url + ' )';
			preview.classList.remove( 'bordered' );
			upload.classList.add( 'hide' );
			remove.classList.remove( 'hide' );

		});

		fileFrame.close();

	}

	/**
	 * Removes the field value. Toggles the links.
	 *
	 * @param 		object 		e 			The event object
	 */
	function removeFileFromField( e ) {

		e.preventDefault();

		var parent, field, upload, remove, preview;

		remove = this;
		parent = this.parentNode;
		field = parent.querySelector( '[type="hidden"]' );
		upload = parent.querySelector( '#upload-img' );
		preview = parent.querySelector( '.image-upload-preview' );

		field.value = '';
		preview.style.backgroundImage = '';
		preview.classList.add( 'bordered' );
		remove.classList.add( 'hide' );
		upload.classList.remove( 'hide' );

	}

	for( var i = 0; i < len; i++ ) {

		var upload, remove;

		upload = fields[i].querySelector( '#upload-img' );
		remove = fields[i].querySelector( '#remove-img' );

		if ( ! upload && ! remove ) { continue; }

		upload.addEventListener( 'click', openMediaLibraryChooser, false );
		remove.addEventListener( 'click', removeFileFromField, false );

	}

})();
