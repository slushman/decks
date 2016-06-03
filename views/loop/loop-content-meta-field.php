<?php
/**
 * The view for the meta data field used in the loop
 */

if ( empty( $meta['meta_field'][0] ) ) { return; }

?><p class="decks-meta-field"><?php echo esc_html( $meta['meta_field'][0] ); ?></p>