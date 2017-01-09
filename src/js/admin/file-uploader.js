/**
 * Adds/removes file or image to selected field.
 */
( function( $ ){

	/**
	 * Find ecah file uploader field parent element.
	 */
	var fileFields = document.querySelectorAll( '.file-upload-field' );

	/**
	 * Returns the event target.
	 *
	 * @param 		object 		event 		The event.
	 * @return 		object 		target 		The event target.
	 */
	function getEventTarget( event ) {

		event = event || window.event;

		return event.target || event.srcElement;

	} // getEventTarget()

	/**
	 * Opens the Media Library window.
	 * Sets the field value.
	 * Toggles the links.
	 *
	 * @todo 		Figure out how to get rid of jQuery "on" dependency here.
	 *
	 * @param 		object 		event 			The event.
	 */
	function openMediaLibraryChooser( event, target ) {

		event.preventDefault();

		var fileFrame, json, parent, field, remove, upload;

		upload = target;
		parent = upload.parentNode;
		field = parent.querySelector( '[data-id="url-file"]' );
		remove = parent.querySelector( 'a.remove-file' );

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

		fileFrame.open();

	} // openMediaLibraryChooser()

	/**
	 * Processes the event and call the correct
	 * action based on the event target.
	 *
	 * @param 		object 		event 		The event.
	 */
	function processEvent( event ) {

		var target = getEventTarget( event );

		event.stopPropagation();
		event.cancelBubble = true;

		if ( target.matches( '.upload-file' ) ) {

			openMediaLibraryChooser( event, target );

		}

		if ( target.matches( '.remove-file' ) ) {

			removeFileFromField( event, target );

		}

	} // processEvent()

	/**
	 * Removes the field value. Toggles the links.
	 *
	 * @param 		object 		event 		The event.
	 */
	function removeFileFromField( event, target ) {

		event.preventDefault();

		var parent, field, upload, remove;

		remove = target;
		parent = remove.parentNode;
		field = parent.querySelector( '[data-id="url-file"]' );
		upload = parent.querySelector( '#upload-file' );

		field.value = '';
		remove.classList.add( 'hide' );
		upload.classList.remove( 'hide' );

	} // removeFileFromField()

	/**
	 * Checks if the nodes are empty and if not, sets event
	 * listeners on each node.
	 *
	 * @param 		object 		nodes 		A list of nodes.
	 */
	function setEvents( nodes ) {

		if ( ! nodes || 0 >= nodes.length ) { return; }

		for ( var n = 0; n < nodes.length; n++ ) {

			nodes[n].addEventListener( 'click', processEvent );

		}

	} // setEvents()

	/**
	 * Set the events for each file uploader found.
	 */
	 setEvents( fileFields );

})( jQuery );
