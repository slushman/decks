<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://wpdecks.com
 * @since      1.0.0
 *
 * @package    Decks
 * @subpackage Decks/classes/views
 */

?><h1><?php echo esc_html( get_admin_page_title() ); ?></h1><?php

echo $this->sections_menu();

?><form method="post" action="options.php"><?php

settings_fields( DECKS_SLUG . '_options' );

do_settings_sections( DECKS_SLUG );

submit_button( 'Save Settings' );

?></form>
