<?php

add_action( 'wp_enqueue_scripts', function () {
	$parent_handle = 'astra-theme-css';
	$parent_uri    = get_template_directory_uri() . '/style.css';

	wp_enqueue_style( $parent_handle, $parent_uri, array(), wp_get_theme( 'astra' )->get( 'Version' ) );
	wp_enqueue_style( 'gharseva-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap', array(), null );
	wp_enqueue_style(
		'astra-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_handle ),
		wp_get_theme()->get( 'Version' )
	);
}, 20 );

function gharesva_get_setting( $field_name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	// Prefer Contact page fields, then Home page fields.
	$value = get_field( $field_name, 11 );
	if ( ! empty( $value ) ) {
		return $value;
	}
	$value = get_field( $field_name, 6 );
	if ( ! empty( $value ) ) {
		return $value;
	}
	return $default;
}

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_gharseva_site_settings',
			'title'                 => 'GharSeva: Site Settings',
			'fields'                => array(
				array(
					'key'   => 'field_gharseva_phone',
					'label' => 'Phone',
					'name'  => 'gharseva_phone',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_whatsapp',
					'label' => 'WhatsApp Number',
					'name'  => 'gharseva_whatsapp',
					'type'  => 'text',
					'instructions' => 'Example: 919999999999 (country code + number, no +, no spaces)',
				),
				array(
					'key'   => 'field_gharseva_email',
					'label' => 'Email',
					'name'  => 'gharseva_email',
					'type'  => 'email',
				),
				array(
					'key'   => 'field_gharseva_address',
					'label' => 'Address (Optional)',
					'name'  => 'gharseva_address',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_gharseva_service_area',
					'label' => 'Service Area',
					'name'  => 'gharseva_service_area',
					'type'  => 'textarea',
					'rows'  => 3,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
					array(
						'param'    => 'post_id',
						'operator' => '==',
						'value'    => '11',
					),
				),
			),
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_gharseva_home_settings',
			'title'                 => 'GharSeva: Home Page',
			'fields'                => array(
				array(
					'key'   => 'field_gharseva_hero_badge',
					'label' => 'Hero Badge',
					'name'  => 'gharseva_hero_badge',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_hero_heading',
					'label' => 'Hero Heading',
					'name'  => 'gharseva_hero_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_hero_subheading',
					'label' => 'Hero Subheading',
					'name'  => 'gharseva_hero_subheading',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_gharseva_home_highlights',
					'label' => 'Highlights (one per line)',
					'name'  => 'gharseva_home_highlights',
					'type'  => 'textarea',
					'rows'  => 5,
				),
				array(
					'key'   => 'field_gharseva_stat_1_value',
					'label' => 'Stat 1 Value',
					'name'  => 'gharseva_stat_1_value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_stat_1_label',
					'label' => 'Stat 1 Label',
					'name'  => 'gharseva_stat_1_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_stat_2_value',
					'label' => 'Stat 2 Value',
					'name'  => 'gharseva_stat_2_value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_stat_2_label',
					'label' => 'Stat 2 Label',
					'name'  => 'gharseva_stat_2_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_stat_3_value',
					'label' => 'Stat 3 Value',
					'name'  => 'gharseva_stat_3_value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_stat_3_label',
					'label' => 'Stat 3 Label',
					'name'  => 'gharseva_stat_3_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gharseva_how_steps',
					'label' => 'How It Works (3 steps, one per line, format: Title | Description)',
					'name'  => 'gharseva_how_steps',
					'type'  => 'textarea',
					'rows'  => 6,
				),
				array(
					'key'   => 'field_gharseva_why_points',
					'label' => 'Why Choose Us (one per line)',
					'name'  => 'gharseva_why_points',
					'type'  => 'textarea',
					'rows'  => 6,
				),
				array(
					'key'   => 'field_gharseva_testimonials',
					'label' => 'Testimonials (3 items, one per line, format: Name | Text)',
					'name'  => 'gharseva_testimonials',
					'type'  => 'textarea',
					'rows'  => 6,
				),
				array(
					'key'   => 'field_gharseva_pricing_plans',
					'label' => 'Pricing Plans (3 items, one per block, format: Name\\nPrice\\nLine1\\nLine2\\nLine3)',
					'name'  => 'gharseva_pricing_plans',
					'type'  => 'textarea',
					'rows'  => 12,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
					array(
						'param'    => 'post_id',
						'operator' => '==',
						'value'    => '6',
					),
				),
			),
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_gharseva_service_fields',
			'title'                 => 'GharSeva: Service Details',
			'fields'                => array(
				array(
					'key'           => 'field_gharseva_service_icon',
					'label'         => 'Icon (Emoji)',
					'name'          => 'gharseva_service_icon',
					'type'          => 'text',
					'instructions'  => 'Example: 💆‍♀️',
					'wrapper'       => array( 'width' => 50 ),
				),
				array(
					'key'           => 'field_gharseva_service_tag',
					'label'         => 'Tag (Optional)',
					'name'          => 'gharseva_service_tag',
					'type'          => 'text',
					'instructions'  => 'Example: Most Popular',
					'wrapper'       => array( 'width' => 50 ),
				),
				array(
					'key'   => 'field_gharseva_service_short',
					'label' => 'Short Summary',
					'name'  => 'gharseva_service_short',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_gharseva_price_60',
					'label' => 'Price (60 min) ₹',
					'name'  => 'gharseva_price_60',
					'type'  => 'number',
					'min'   => 0,
				),
				array(
					'key'   => 'field_gharseva_price_90',
					'label' => 'Price (90 min) ₹',
					'name'  => 'gharseva_price_90',
					'type'  => 'number',
					'min'   => 0,
				),
				array(
					'key'          => 'field_gharseva_benefits',
					'label'        => 'Benefits (one per line)',
					'name'         => 'gharseva_benefits',
					'type'         => 'textarea',
					'rows'         => 5,
				),
				array(
					'key'          => 'field_gharseva_before_after',
					'label'        => 'Before / After Care (one per line)',
					'name'         => 'gharseva_before_after',
					'type'         => 'textarea',
					'rows'         => 5,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'gharseva_service',
					),
				),
			),
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
} );

add_filter( 'acf/settings/save_json', function ( $path ) {
	return get_stylesheet_directory() . '/acf-json';
} );

add_filter( 'acf/settings/load_json', function ( $paths ) {
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
} );

add_action( 'init', function () {
	register_post_type(
		'gharseva_service',
		array(
			'labels'              => array(
				'name'          => 'Services',
				'singular_name' => 'Service',
			),
			'public'              => true,
			'has_archive'         => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-heart',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'rewrite'             => array( 'slug' => 'services' ),
			'exclude_from_search' => false,
		)
	);

	register_post_type(
		'gharseva_lead',
		array(
			'labels'              => array(
				'name'          => 'Leads',
				'singular_name' => 'Lead',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-forms',
			'supports'            => array( 'title', 'editor', 'custom-fields' ),
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'exclude_from_search' => true,
		)
	);
} );

add_action( 'wp_footer', function () {
	$whatsapp = preg_replace( '/\\D+/', '', (string) gharesva_get_setting( 'gharseva_whatsapp' ) );
	$phone    = (string) gharesva_get_setting( 'gharseva_phone' );

	if ( '' === $whatsapp && '' === $phone ) {
		return;
	}

	$link = '';
	if ( '' !== $whatsapp ) {
		$link = 'https://wa.me/' . rawurlencode( $whatsapp );
	} elseif ( '' !== $phone ) {
		$link = 'tel:' . preg_replace( '/\\s+/', '', $phone );
	}

	echo '<div style="position:fixed;right:16px;bottom:16px;z-index:9999;">';
	echo '<a href="' . esc_url( $link ) . '" style="display:inline-block;padding:12px 14px;border-radius:999px;background:#0b5fff;color:#fff;text-decoration:none;font-weight:600;box-shadow:0 6px 20px rgba(0,0,0,.15);">Book on WhatsApp</a>';
	echo '</div>';
}, 99 );

add_shortcode( 'gharseva_booking_form', function () {
	if ( is_admin() ) {
		return '';
	}

	$errors = array();
	$sent   = false;

	if ( 'POST' === ( $_SERVER['REQUEST_METHOD'] ?? '' ) && isset( $_POST['gharseva_booking_nonce'] ) ) {
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gharseva_booking_nonce'] ) ), 'gharseva_booking' ) ) {
			$errors[] = 'Invalid request. Please refresh and try again.';
		} else {
			$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
			$phone   = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
			$service = sanitize_text_field( wp_unslash( $_POST['service'] ?? '' ) );
			$date    = sanitize_text_field( wp_unslash( $_POST['date'] ?? '' ) );
			$time    = sanitize_text_field( wp_unslash( $_POST['time'] ?? '' ) );
			$area    = sanitize_text_field( wp_unslash( $_POST['area'] ?? '' ) );
			$notes   = sanitize_textarea_field( wp_unslash( $_POST['notes'] ?? '' ) );

			if ( '' === $name ) {
				$errors[] = 'Please enter your name.';
			}
			if ( '' === $phone ) {
				$errors[] = 'Please enter your phone number.';
			}
			if ( '' === $service ) {
				$errors[] = 'Please select a service.';
			}

			if ( ! $errors ) {
				$lead_id = wp_insert_post(
					array(
						'post_type'    => 'gharseva_lead',
						'post_status'  => 'publish',
						'post_title'   => sprintf( '%s — %s', $name, $phone ),
						'post_content' => "Service: {$service}\nDate: {$date}\nTime: {$time}\nArea: {$area}\n\nNotes:\n{$notes}\n",
					),
					true
				);

				$admin_email = get_option( 'admin_email' );
				$subject     = 'New Booking Request';
				$message     = "New booking request:\n\nName: {$name}\nPhone: {$phone}\nService: {$service}\nDate: {$date}\nTime: {$time}\nArea: {$area}\nNotes: {$notes}\n";

				wp_mail( $admin_email, $subject, $message );

				$sent = ! is_wp_error( $lead_id );
				if ( ! $sent ) {
					$errors[] = 'Could not save your request. Please try again.';
				}
			}
		}
	}

	ob_start();
	$service_options = array();
	$services_query  = new WP_Query(
		array(
			'post_type'      => 'gharseva_service',
			'posts_per_page' => 50,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	if ( $services_query->have_posts() ) {
		while ( $services_query->have_posts() ) {
			$services_query->the_post();
			$service_options[] = get_the_title();
		}
		wp_reset_postdata();
	}
	if ( ! $service_options ) {
		$service_options = array( 'Swedish Massage', 'Deep Tissue Massage', 'Aromatherapy Massage', 'Couple Massage' );
	}
	?>
	<div class="gharseva-booking">
		<?php if ( $sent ) : ?>
			<p><strong>Thanks!</strong> Your request is received. We will contact you soon.</p>
		<?php else : ?>
			<?php if ( $errors ) : ?>
				<div class="gharseva-booking-errors">
					<?php foreach ( $errors as $error ) : ?>
						<p><?php echo esc_html( $error ); ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<form method="post">
				<div class="form-group">
					<label>Your Full Name</label>
					<input type="text" name="name" required placeholder="e.g. Priya Sharma" value="<?php echo esc_attr( wp_unslash( $_POST['name'] ?? '' ) ); ?>" />
				</div>
				<div class="form-group">
					<label>Phone / WhatsApp Number</label>
					<input type="tel" name="phone" required placeholder="+91 9876543210" value="<?php echo esc_attr( wp_unslash( $_POST['phone'] ?? '' ) ); ?>" />
				</div>
				<div class="form-group">
					<label>Your Area in Gurugram</label>
					<input type="text" name="area" placeholder="e.g. DLF Phase 2, Sector 49..." value="<?php echo esc_attr( wp_unslash( $_POST['area'] ?? '' ) ); ?>" />
				</div>
				<div class="form-group">
					<label>Service Needed</label>
					<select name="service" required>
						<option value="">Select a service...</option>
						<?php foreach ( $service_options as $opt ) : ?>
							<option value="<?php echo esc_attr( $opt ); ?>" <?php selected( ( $_POST['service'] ?? '' ), $opt ); ?>><?php echo esc_html( $opt ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label>Preferred Date</label>
					<input type="date" name="date" value="<?php echo esc_attr( wp_unslash( $_POST['date'] ?? '' ) ); ?>" />
				</div>
				<div class="form-group">
					<label>Preferred Time</label>
					<input type="text" name="time" placeholder="e.g. 6:00 PM" value="<?php echo esc_attr( wp_unslash( $_POST['time'] ?? '' ) ); ?>" />
				</div>
				<div class="form-group">
					<label>Any Special Requirements?</label>
					<textarea name="notes" placeholder="Tell us your timing, any preferences, problem area, etc..."><?php echo esc_textarea( wp_unslash( $_POST['notes'] ?? '' ) ); ?></textarea>
				</div>
				<?php wp_nonce_field( 'gharseva_booking', 'gharseva_booking_nonce' ); ?>
				<button class="form-submit" type="submit">📲 Send Booking Request</button>
			</form>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
} );
