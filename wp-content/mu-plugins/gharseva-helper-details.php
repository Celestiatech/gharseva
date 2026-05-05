<?php
/**
 * Plugin Name: GharSeva Helper Details
 * Description: Adds per-post meta fields (Age, Phone, WhatsApp) and displays them in Bloghash entry meta.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GHARSEVA_META_AGE', '_gharseva_age' );
define( 'GHARSEVA_META_PHONE', '_gharseva_phone' );
define( 'GHARSEVA_META_WHATSAPP', '_gharseva_whatsapp' );

// Admin UI toggles (to avoid duplicates with your child-theme meta boxes).
if ( ! defined( 'GHARSEVA_HELPER_DETAILS_ENABLE_AGE_METABOX' ) ) {
	define( 'GHARSEVA_HELPER_DETAILS_ENABLE_AGE_METABOX', true );
}
if ( ! defined( 'GHARSEVA_HELPER_DETAILS_ENABLE_CONTACT_METABOX' ) ) {
	define( 'GHARSEVA_HELPER_DETAILS_ENABLE_CONTACT_METABOX', false );
}

// Frontend output mode: 'age_only' (default) or 'all'.
if ( ! defined( 'GHARSEVA_HELPER_DETAILS_FRONTEND_MODE' ) ) {
	define( 'GHARSEVA_HELPER_DETAILS_FRONTEND_MODE', 'age_only' );
}

function gharseva_add_post_contact_metabox() {
	if ( ! GHARSEVA_HELPER_DETAILS_ENABLE_AGE_METABOX && ! GHARSEVA_HELPER_DETAILS_ENABLE_CONTACT_METABOX ) {
		return;
	}
	add_meta_box(
		'gharseva_post_contact',
		esc_html__( 'Helper Details (Age & Contact)', 'gharseva' ),
		'gharseva_render_post_contact_metabox',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'gharseva_add_post_contact_metabox' );

function gharseva_render_post_contact_metabox( $post ) {
	if ( ! GHARSEVA_HELPER_DETAILS_ENABLE_AGE_METABOX && ! GHARSEVA_HELPER_DETAILS_ENABLE_CONTACT_METABOX ) {
		return;
	}
	wp_nonce_field( 'gharseva_post_contact_save', 'gharseva_post_contact_nonce' );

	$age      = get_post_meta( $post->ID, GHARSEVA_META_AGE, true );
	$phone    = get_post_meta( $post->ID, GHARSEVA_META_PHONE, true );
	$whatsapp = get_post_meta( $post->ID, GHARSEVA_META_WHATSAPP, true );
	?>
	<?php if ( GHARSEVA_HELPER_DETAILS_ENABLE_AGE_METABOX ) { ?>
		<p>
			<label for="gharseva_age"><strong><?php esc_html_e( 'Age', 'gharseva' ); ?></strong></label><br />
			<input type="number" id="gharseva_age" name="gharseva_age" min="0" step="1" style="width:100%;"
				value="<?php echo esc_attr( $age ); ?>" placeholder="<?php echo esc_attr__( 'e.g. 24', 'gharseva' ); ?>" />
		</p>
	<?php } ?>
	<?php if ( GHARSEVA_HELPER_DETAILS_ENABLE_CONTACT_METABOX ) { ?>
		<p>
			<label for="gharseva_phone"><strong><?php esc_html_e( 'Phone (Call)', 'gharseva' ); ?></strong></label><br />
			<input type="text" id="gharseva_phone" name="gharseva_phone" style="width:100%;"
				value="<?php echo esc_attr( $phone ); ?>" placeholder="<?php echo esc_attr__( 'e.g. 919805559015', 'gharseva' ); ?>" />
			<small><?php esc_html_e( 'Use digits with country code (no +).', 'gharseva' ); ?></small>
		</p>
		<p>
			<label for="gharseva_whatsapp"><strong><?php esc_html_e( 'WhatsApp', 'gharseva' ); ?></strong></label><br />
			<input type="text" id="gharseva_whatsapp" name="gharseva_whatsapp" style="width:100%;"
				value="<?php echo esc_attr( $whatsapp ); ?>" placeholder="<?php echo esc_attr__( 'e.g. 919805559015', 'gharseva' ); ?>" />
			<small><?php esc_html_e( 'Leave empty to use Phone number.', 'gharseva' ); ?></small>
		</p>
	<?php } ?>
	<?php
}

function gharseva_sanitize_digits( $value ) {
	$value = (string) $value;
	$value = preg_replace( '/\\D+/', '', $value );
	return $value ? $value : '';
}

function gharseva_save_post_contact_metabox( $post_id ) {
	if ( ! GHARSEVA_HELPER_DETAILS_ENABLE_AGE_METABOX && ! GHARSEVA_HELPER_DETAILS_ENABLE_CONTACT_METABOX ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	if (
		! isset( $_POST['gharseva_post_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gharseva_post_contact_nonce'] ) ), 'gharseva_post_contact_save' )
	) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( GHARSEVA_HELPER_DETAILS_ENABLE_AGE_METABOX ) {
		$age = isset( $_POST['gharseva_age'] ) ? absint( wp_unslash( $_POST['gharseva_age'] ) ) : 0; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		if ( $age > 0 ) {
			update_post_meta( $post_id, GHARSEVA_META_AGE, (string) $age );
		} else {
			delete_post_meta( $post_id, GHARSEVA_META_AGE );
		}
	}

	if ( GHARSEVA_HELPER_DETAILS_ENABLE_CONTACT_METABOX ) {
		$phone    = isset( $_POST['gharseva_phone'] ) ? gharseva_sanitize_digits( wp_unslash( $_POST['gharseva_phone'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$whatsapp = isset( $_POST['gharseva_whatsapp'] ) ? gharseva_sanitize_digits( wp_unslash( $_POST['gharseva_whatsapp'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		if ( $phone ) {
			update_post_meta( $post_id, GHARSEVA_META_PHONE, $phone );
		} else {
			delete_post_meta( $post_id, GHARSEVA_META_PHONE );
		}

		if ( $whatsapp ) {
			update_post_meta( $post_id, GHARSEVA_META_WHATSAPP, $whatsapp );
		} else {
			delete_post_meta( $post_id, GHARSEVA_META_WHATSAPP );
		}
	}
}
add_action( 'save_post', 'gharseva_save_post_contact_metabox' );

function gharseva_entry_meta_contact_styles() {
	if ( 'off' === GHARSEVA_HELPER_DETAILS_FRONTEND_MODE ) {
		return;
	}
	?>
	<style>
		.entry-meta .entry-meta-elements > span.post-contact-call,
		.entry-meta .entry-meta-elements > span.post-contact-whatsapp,
		.entry-meta .entry-meta-elements > span.post-age { margin-right: 14px; display: inline-flex; align-items: center; gap: 6px; }
		.entry-meta .entry-meta-elements .contact-button { display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
		.entry-meta .entry-meta-elements .contact-button .bloghash-icon { width: 16px; height: 16px; }
	</style>
	<?php
}
add_action( 'wp_head', 'gharseva_entry_meta_contact_styles' );

function gharseva_output_entry_meta_contacts() {
	if ( 'off' === GHARSEVA_HELPER_DETAILS_FRONTEND_MODE ) {
		return;
	}
	if ( ! function_exists( 'bloghash' ) ) {
		return;
	}

	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return;
	}

	$age      = get_post_meta( $post_id, GHARSEVA_META_AGE, true );
	$phone    = get_post_meta( $post_id, GHARSEVA_META_PHONE, true );
	$whatsapp = get_post_meta( $post_id, GHARSEVA_META_WHATSAPP, true );

	$age      = $age ? absint( $age ) : 0;
	$phone    = $phone ? gharseva_sanitize_digits( $phone ) : '';
	$whatsapp = $whatsapp ? gharseva_sanitize_digits( $whatsapp ) : '';
	if ( ! $whatsapp && $phone ) {
		$whatsapp = $phone;
	}

	if ( $age > 0 ) {
		echo '<span class="post-age">' . esc_html( sprintf( 'Age %d', $age ) ) . '</span>';
	}

	if ( 'age_only' === GHARSEVA_HELPER_DETAILS_FRONTEND_MODE ) {
		return;
	}

	// If your Bloghash child-theme contact meta exists, do not output duplicates.
	$child_call     = get_post_meta( $post_id, '_bloghash_child_call_number', true );
	$child_whatsapp = get_post_meta( $post_id, '_bloghash_child_whatsapp_number', true );
	if ( $child_call || $child_whatsapp ) {
		return;
	}

	if ( $phone ) {
		$icon = bloghash()->icons->get_svg( 'phone', array( 'aria-hidden' => 'true' ) );
		echo '<span class="post-contact-call"><a href="' . esc_url( 'tel:' . $phone ) . '" class="contact-button call-button" title="' . esc_attr__( 'Call', 'gharseva' ) . '">'
			. wp_kses( $icon, bloghash_get_allowed_html_tags() )
			. '<span class="contact-text">' . esc_html__( 'Call', 'gharseva' ) . '</span></a></span>';
	}

	if ( $whatsapp ) {
		$icon = bloghash()->icons->get_svg( 'whatsapp', array( 'aria-hidden' => 'true' ) );
		echo '<span class="post-contact-whatsapp"><a href="' . esc_url( 'https://wa.me/' . $whatsapp ) . '" target="_blank" rel="noopener noreferrer" class="contact-button whatsapp-button" title="' . esc_attr__( 'Chat on WhatsApp', 'gharseva' ) . '">'
			. wp_kses( $icon, bloghash_get_allowed_html_tags() )
			. '<span class="contact-text">' . esc_html__( 'WhatsApp', 'gharseva' ) . '</span></a></span>';
	}
}
add_action( 'bloghash_after_entry_meta_elements', 'gharseva_output_entry_meta_contacts' );

/**
 * Homepage posts-per-page override (Settings → Reading).
 */
function gharseva_register_home_posts_setting() {
	register_setting(
		'reading',
		'gharseva_home_posts_per_page',
		array(
			'type'              => 'integer',
			'sanitize_callback' => 'absint',
			'default'           => 10,
		)
	);

	add_settings_field(
		'gharseva_home_posts_per_page',
		esc_html__( 'Homepage posts per page', 'gharseva' ),
		'gharseva_home_posts_setting_field',
		'reading',
		'default'
	);
}
add_action( 'admin_init', 'gharseva_register_home_posts_setting' );

function gharseva_home_posts_setting_field() {
	$value = (int) get_option( 'gharseva_home_posts_per_page', 0 );
	?>
	<input
		type="number"
		min="1"
		step="1"
		name="gharseva_home_posts_per_page"
		id="gharseva_home_posts_per_page"
		value="<?php echo esc_attr( $value ? $value : 10 ); ?>"
		class="small-text"
	/>
	<p class="description"><?php esc_html_e( 'Applies to the homepage post list only.', 'gharseva' ); ?></p>
	<?php
}

function gharseva_home_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	// Front page is showing latest posts.
	if ( $query->is_home() ) {
		$value = absint( get_option( 'gharseva_home_posts_per_page', 0 ) );
		if ( $value >= 1 ) {
			$query->set( 'posts_per_page', $value );
		}
	}
}
add_action( 'pre_get_posts', 'gharseva_home_posts_per_page' );
