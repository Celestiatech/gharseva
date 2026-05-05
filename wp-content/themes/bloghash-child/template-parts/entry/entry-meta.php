<?php
/**
 * Template part for displaying entry meta info with Call and WhatsApp buttons.
 * Child theme override - replaces author and date with contact buttons.
 *
 * @package     bloghash-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only show meta tags for posts.
if ( ! in_array( get_post_type(), (array) apply_filters( 'bloghash_entry_meta_post_type', array( 'post' ) ), true ) ) {
	return;
}

do_action( 'bloghash_before_entry_meta' );

$call_number    = get_post_meta( get_the_ID(), '_bloghash_child_call_number', true );
$whatsapp_number = get_post_meta( get_the_ID(), '_bloghash_child_whatsapp_number', true );

if ( ! empty( $call_number ) || ! empty( $whatsapp_number ) ) {
	echo '<div class="entry-meta"><div class="entry-meta-elements">';

	do_action( 'bloghash_before_entry_meta_elements' );

	// Call button
	if ( ! empty( $call_number ) ) {
		$call_number = sanitize_text_field( $call_number );
		echo '<span class="post-contact-call">';
		echo '<a href="tel:' . esc_attr( $call_number ) . '" class="contact-button call-button" title="Call us">';
		echo '<svg class="bloghash-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M164.9 24.6c-7.7-18.6-28-28.6-47.4-23.6l-88 24C12.1 30.7 0 46.9 0 64C0 311.4 200.6 512 448 512c17.1 0 33.3-12.1 38-29.6l24-88c5-19.4-5-39.7-23.6-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>';
		echo '<span class="contact-text">Call</span>';
		echo '</a>';
		echo '</span>';
	}

	// WhatsApp button
	if ( ! empty( $whatsapp_number ) ) {
		$whatsapp_number = sanitize_text_field( $whatsapp_number );
		echo '<span class="post-contact-whatsapp">';
		echo '<a href="https://wa.me/' . esc_attr( preg_replace( '/[^0-9+]/', '', $whatsapp_number ) ) . '" target="_blank" rel="noopener noreferrer" class="contact-button whatsapp-button" title="Chat on WhatsApp">';
		echo '<svg class="bloghash-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.9 68.9 27.3 106.1 27.3 122.4 0 222-99.6 222-222 0-59.3-23.1-115-65.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3 18.6-67.9-4.3-6.8c-18.5-29.4-28.3-63.3-28.3-98.7 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.6-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.5 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>';
		echo '<span class="contact-text">WhatsApp</span>';
		echo '</a>';
		echo '</span>';
	}

	do_action( 'bloghash_after_entry_meta_elements' );

	echo '</div></div>';
}

do_action( 'bloghash_after_entry_meta' );
