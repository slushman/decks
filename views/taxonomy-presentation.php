<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php // get presentation title ?></title>
	<meta charset="utf-8"><?php

	wp_head();

?></head>
<body>
	<div class="reveal">
		<div class="slides"><?php

		/**
		 * decks_slides action hook
		 *
		 * All slides are hooked here.
		 *
		 * @hooked 		get_slides
		 * @param 		string 			$presentation 		The presentation slug.
		 */
		do_action( 'decks_slides', $presentation );

		?></div><!-- .slides -->
	</div><!-- .reveal --><?php

	/**
	 * decks_footer action hook
	 *
	 * @hooked 		initialize_reveal
	 * @param 		string 			$presentation 		The presentation slug.
	 */
	do_action( 'decks_footer', $presentation );

	wp_footer();

?></body>
</html>
