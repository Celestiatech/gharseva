<?php
/**
 * BlogHash Child Theme Functions
 *
 * @package bloghash-child
 */

/**
 * Enqueue parent and child theme stylesheets
 */
function bloghash_child_enqueue_styles() {
	wp_enqueue_style(
		'bloghash-parent-style',
		get_template_directory_uri() . '/style.css'
	);

	wp_enqueue_style(
		'bloghash-child-style',
		get_stylesheet_uri(),
		array( 'bloghash-parent-style' ),
		wp_get_theme()->get( 'Version' )
	);
}

add_action( 'wp_enqueue_scripts', 'bloghash_child_enqueue_styles' );

/**
 * Register call and WhatsApp phone number meta fields for posts
 */
function bloghash_child_register_post_meta() {
	register_post_meta(
		'post',
		'_bloghash_child_call_number',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'show_in_rest'      => true,
			'single'            => true,
		)
	);

	register_post_meta(
		'post',
		'_bloghash_child_whatsapp_number',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'show_in_rest'      => true,
			'single'            => true,
		)
	);
}

add_action( 'init', 'bloghash_child_register_post_meta' );

/**
 * Add meta boxes for call and WhatsApp numbers
 */
function bloghash_child_add_contact_meta_boxes() {
	add_meta_box(
		'bloghash_child_call_number',
		__( 'Call Button - Phone Number', 'bloghash-child' ),
		'bloghash_child_call_meta_box_callback',
		'post',
		'normal',
		'high'
	);

	add_meta_box(
		'bloghash_child_whatsapp_number',
		__( 'WhatsApp Button - Phone Number', 'bloghash-child' ),
		'bloghash_child_whatsapp_meta_box_callback',
		'post',
		'normal',
		'high'
	);
}

add_action( 'add_meta_boxes', 'bloghash_child_add_contact_meta_boxes' );

/**
 * Call meta box callback
 */
function bloghash_child_call_meta_box_callback( $post ) {
	$call_number = get_post_meta( $post->ID, '_bloghash_child_call_number', true );
	wp_nonce_field( 'bloghash_child_contact_nonce', 'bloghash_child_contact_nonce' );
	?>
	<label for="bloghash_child_call_number"><?php esc_html_e( 'Phone Number for Call Button (include country code, e.g., +91 XXXXX XXXXX):', 'bloghash-child' ); ?></label>
	<input 
		type="text" 
		id="bloghash_child_call_number" 
		name="bloghash_child_call_number" 
		value="<?php echo esc_attr( $call_number ); ?>" 
		placeholder="+91 XXXXX XXXXX"
		style="width: 100%; padding: 8px; margin-top: 5px;"
	>
	<p style="color: #666; margin-top: 5px;">
		<?php esc_html_e( 'This phone number will be used for the Call button. Users can click to call this number.', 'bloghash-child' ); ?>
	</p>
	<?php
}

/**
 * WhatsApp meta box callback
 */
function bloghash_child_whatsapp_meta_box_callback( $post ) {
	$whatsapp_number = get_post_meta( $post->ID, '_bloghash_child_whatsapp_number', true );
	wp_nonce_field( 'bloghash_child_contact_nonce', 'bloghash_child_contact_nonce' );
	?>
	<label for="bloghash_child_whatsapp_number"><?php esc_html_e( 'Phone Number for WhatsApp Button (include country code, e.g., +91 XXXXX XXXXX):', 'bloghash-child' ); ?></label>
	<input 
		type="text" 
		id="bloghash_child_whatsapp_number" 
		name="bloghash_child_whatsapp_number" 
		value="<?php echo esc_attr( $whatsapp_number ); ?>" 
		placeholder="+91 XXXXX XXXXX"
		style="width: 100%; padding: 8px; margin-top: 5px;"
	>
	<p style="color: #666; margin-top: 5px;">
		<?php esc_html_e( 'This phone number will be used for the WhatsApp button. Users can click to open WhatsApp chat.', 'bloghash-child' ); ?>
	</p>
	<?php
}

/**
 * Save contact meta fields
 */
function bloghash_child_save_contact_meta( $post_id ) {
	if ( ! isset( $_POST['bloghash_child_contact_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['bloghash_child_contact_nonce'], 'bloghash_child_contact_nonce' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save call number
	if ( isset( $_POST['bloghash_child_call_number'] ) ) {
		$call_number = sanitize_text_field( $_POST['bloghash_child_call_number'] );
		update_post_meta( $post_id, '_bloghash_child_call_number', $call_number );
	} else {
		delete_post_meta( $post_id, '_bloghash_child_call_number' );
	}

	// Save WhatsApp number
	if ( isset( $_POST['bloghash_child_whatsapp_number'] ) ) {
		$whatsapp_number = sanitize_text_field( $_POST['bloghash_child_whatsapp_number'] );
		update_post_meta( $post_id, '_bloghash_child_whatsapp_number', $whatsapp_number );
	} else {
		delete_post_meta( $post_id, '_bloghash_child_whatsapp_number' );
	}
}

add_action( 'save_post', 'bloghash_child_save_contact_meta' );
