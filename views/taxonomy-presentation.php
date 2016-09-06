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
		 * @hooked 			get_slides
		 */
		do_action( 'decks_slides' );

		?></div><!-- .slides -->
	</div><!-- .reveal -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/headjs/1.0.3/head.min.js"></script>
	<script src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ); ?>assets/js/reveal.min.js"></script>
	<script>
		Reveal.initialize({<?php

		/**
		 * decks_initialize action hook
		 *
		 * All plugin settings are hooked here.
		 *
		 * @hooked
		 */
		do_action( 'decks_initialize', $presentation );

		?>});
	</script><?php

	wp_footer();

?></body>
</html>
