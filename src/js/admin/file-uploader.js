/**
 * Adds/removes file or image to selected field.
 */
( function(){

	var fields = document.querySelectorAll( '.file-upload-field' );
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

		var fileFrame, json, parent, field, remove, upload;

		upload = this;
		parent = this.parentNode;
		field = parent.querySelector( '[data-id="url-file"]' );
		remove = parent.querySelector( '#remove-file' );

		if ( undefined !== fileFrame ) {

			fileFrame.open();
			return;

		}

		fileFrame = wp.media.frames.fileFrame = wp.media({
			button: {
				text: 'Choose File',
			},
			frame: 'select',
			multiple: false,
			title: 'Choose file'
		});

		fileFrame.on( 'select', function(){ // must use jQuery here - TODO - explore options

			json = fileFrame.state().get( 'selection' ).first().toJSON();

			if ( 0 >= json.url.length ) { return; }

			field.value = json.url;
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

		var parent, field, upload, remove;

		remove = this;
		parent = this.parentNode;
		field = parent.querySelector( '[data-id="url-file"]' );
		upload = parent.querySelector( '#upload-file' );

		field.value = '';
		remove.classList.add( 'hide' );
		upload.classList.remove( 'hide' );

	}

	for( var i = 0; i < len; i++ ) {

		var upload, remove;

		upload = fields[i].querySelector( '#upload-file' );
		remove = fields[i].querySelector( '#remove-file' );

		if ( ! upload && ! remove ) { continue; }

		upload.addEventListener( 'click', openMediaLibraryChooser, false );
		remove.addEventListener( 'click', removeFileFromField, false );

	}

})();
