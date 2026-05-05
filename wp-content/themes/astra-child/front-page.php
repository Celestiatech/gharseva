<?php
get_header();

$hero_badge      = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_hero_badge', get_the_ID() ) : '';
$hero_heading    = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_hero_heading', get_the_ID() ) : '';
$hero_subheading = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_hero_subheading', get_the_ID() ) : '';
$highlights_raw  = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_home_highlights', get_the_ID() ) : '';

$stat_1_value = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_stat_1_value', get_the_ID() ) : '';
$stat_1_label = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_stat_1_label', get_the_ID() ) : '';
$stat_2_value = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_stat_2_value', get_the_ID() ) : '';
$stat_2_label = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_stat_2_label', get_the_ID() ) : '';
$stat_3_value = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_stat_3_value', get_the_ID() ) : '';
$stat_3_label = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_stat_3_label', get_the_ID() ) : '';

$how_raw          = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_how_steps', get_the_ID() ) : '';
$why_raw          = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_why_points', get_the_ID() ) : '';
$testimonials_raw = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_testimonials', get_the_ID() ) : '';
$plans_raw        = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_pricing_plans', get_the_ID() ) : '';

if ( '' === $hero_heading ) {
	$hero_heading = "You Work Hard.<br/>Let Us Handle <em>Relaxation</em>.";
}
if ( '' === $hero_subheading ) {
	$hero_subheading = 'Premium massage & spa services in Gurugram. Clean, professional care for stress relief, muscle recovery, and deep relaxation.';
}
if ( '' === $hero_badge ) {
	$hero_badge = "Gurugram's Premium Massage & Spa";
}

if ( '' === $stat_1_value ) {
	$stat_1_value = '4.9★';
}
if ( '' === $stat_1_label ) {
	$stat_1_label = 'Avg. Rating';
}
if ( '' === $stat_2_value ) {
	$stat_2_value = '100%';
}
if ( '' === $stat_2_label ) {
	$stat_2_label = 'Hygiene Focus';
}
if ( '' === $stat_3_value ) {
	$stat_3_value = '500+';
}
if ( '' === $stat_3_label ) {
	$stat_3_label = 'Happy Clients';
}

$highlights = array_values(
	array_filter(
		array_map(
			'trim',
			preg_split( "/\\r\\n|\\r|\\n/", $highlights_raw )
		)
	)
);

$book_now_url = get_permalink( 10 );
$services_url = get_post_type_archive_link( 'gharseva_service' );

$how_lines = array_values( array_filter( array_map( 'trim', preg_split( "/\\r\\n|\\r|\\n/", $how_raw ) ) ) );
$why_lines = array_values( array_filter( array_map( 'trim', preg_split( "/\\r\\n|\\r|\\n/", $why_raw ) ) ) );
$t_lines   = array_values( array_filter( array_map( 'trim', preg_split( "/\\r\\n|\\r|\\n/", $testimonials_raw ) ) ) );

$plans_blocks = array_values(
	array_filter(
		array_map(
			'trim',
			preg_split( "/\\r\\n\\s*\\r\\n|\\n\\s*\\n|\\r\\s*\\r/", $plans_raw )
		)
	)
);

?>
<div class="gh-landing">
	<section class="hero">
		<div class="hero-content">
			<div class="hero-badge"><?php echo esc_html( $hero_badge ); ?></div>
			<h1><?php echo wp_kses_post( $hero_heading ); ?></h1>
			<p><?php echo esc_html( $hero_subheading ); ?></p>
			<div class="hero-btns">
				<a href="#contact" class="btn-primary">Book Now</a>
				<a href="#services" class="btn-outline">See All Services</a>
			</div>
			<div class="hero-stats">
				<div class="stat"><strong><?php echo esc_html( $stat_1_value ); ?></strong><span><?php echo esc_html( $stat_1_label ); ?></span></div>
				<div class="stat"><strong><?php echo esc_html( $stat_2_value ); ?></strong><span><?php echo esc_html( $stat_2_label ); ?></span></div>
				<div class="stat"><strong><?php echo esc_html( $stat_3_value ); ?></strong><span><?php echo esc_html( $stat_3_label ); ?></span></div>
			</div>
		</div>
		<div class="hero-img">
			<div class="hero-img-box">💆‍♀️<br/><br/>🕯️ 🌿 ✨<br/><br/>🧖‍♀️</div>
		</div>
	</section>

	<section class="services" id="services">
		<div class="services-header">
			<div class="section-label">Our Services</div>
			<h2 class="section-title">Relax, Rejuvenate & Restore</h2>
			<p class="section-sub">Choose a service and book your preferred time. Clean, professional wellness care in Gurugram.</p>
		</div>
		<div class="services-grid">
			<?php
			$query = new WP_Query(
				array(
					'post_type'      => 'gharseva_service',
					'posts_per_page' => 6,
					'post_status'    => 'publish',
					'orderby'        => 'menu_order title',
					'order'          => 'ASC',
				)
			);
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					$short = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_service_short', get_the_ID() ) : '';
					$icon  = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_service_icon', get_the_ID() ) : '';
					$tag   = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_service_tag', get_the_ID() ) : '';
					if ( '' === $icon ) {
						$icon = '✨';
					}
					?>
					<div class="service-card" onclick="window.location.href='<?php echo esc_url( get_permalink() ); ?>'">
						<div class="service-icon"><?php echo esc_html( $icon ); ?></div>
						<h3><?php the_title(); ?></h3>
						<p><?php echo esc_html( '' !== $short ? $short : wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
						<?php if ( '' !== $tag ) : ?>
							<span class="service-tag"><?php echo esc_html( $tag ); ?></span>
						<?php endif; ?>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</section>

	<section class="how" id="how">
		<div class="how-inner">
			<div>
				<div class="section-label">How It Works</div>
				<h2 class="section-title">Simple, Easy & Reliable</h2>
				<p class="section-sub">Book your session in minutes. We confirm quickly on call/WhatsApp.</p>
				<div class="steps">
					<?php
					$steps = $how_lines;
					if ( ! $steps ) {
						$steps = array(
							'Choose Your Service | Pick massage type and duration.',
							'Share Slot & Area | Tell us your date/time and sector in Gurugram.',
							'Confirm Appointment | We confirm quickly and you are all set.',
						);
					}
					$i = 1;
					foreach ( array_slice( $steps, 0, 3 ) as $line ) :
						$parts = array_map( 'trim', explode( '|', $line, 2 ) );
						$title = $parts[0] ?? '';
						$desc  = $parts[1] ?? '';
						?>
						<div class="step">
							<div class="step-num"><?php echo esc_html( (string) $i ); ?></div>
							<div class="step-text">
								<h4><?php echo esc_html( $title ); ?></h4>
								<p><?php echo esc_html( $desc ); ?></p>
							</div>
						</div>
						<?php
						$i++;
					endforeach;
					?>
				</div>
			</div>
			<div class="how-visual">
				<span class="big-emoji">🧖‍♀️</span>
				<p>Clean environment, trained therapists, and transparent pricing. Feel comfortable and relaxed from start to finish.</p>
			</div>
		</div>
	</section>

	<section class="why" id="why">
		<div class="why-inner">
			<div>
				<div class="section-label">Why Choose Us</div>
				<h2 class="section-title">Premium Care, Every Time</h2>
				<p class="section-sub">Professional service, hygiene focus, and quick confirmations. Your comfort comes first.</p>
			</div>
			<div class="why-cards">
				<?php
				$points = $why_lines;
				if ( ! $points ) {
					$points = array(
						'Hygiene-first setup',
						'Trained therapists',
						'Transparent pricing',
						'Quick WhatsApp support',
					);
				}
				$icons = array( '🧼', '🧑‍⚕️', '💳', '💬' );
				foreach ( array_values( $points ) as $idx => $p ) :
					?>
					<div class="why-card">
						<div class="wi"><?php echo esc_html( $icons[ $idx % count( $icons ) ] ); ?></div>
						<h4><?php echo esc_html( $p ); ?></h4>
						<p>Professional and respectful service.</p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="testimonials" id="testimonials">
		<div class="testimonials-header">
			<div class="section-label">Testimonials</div>
			<h2 class="section-title">Loved by Our Clients</h2>
			<p class="section-sub">Real feedback from people who booked with us in Gurugram.</p>
		</div>
		<div class="testi-grid">
			<?php
			$testimonials = $t_lines;
			if ( ! $testimonials ) {
				$testimonials = array(
					'Riya | Super relaxing session. Clean and professional.',
					'Ankit | Deep tissue helped my back pain a lot.',
					'Neha | Quick booking and great experience overall.',
				);
			}
			foreach ( array_slice( $testimonials, 0, 3 ) as $t ) :
				$parts = array_map( 'trim', explode( '|', $t, 2 ) );
				$name  = $parts[0] ?? 'Client';
				$text  = $parts[1] ?? '';
				?>
				<div class="testi-card">
					<div class="testi-stars">★★★★★</div>
					<blockquote><?php echo esc_html( $text ); ?></blockquote>
					<div class="testi-person">
						<div class="testi-avatar">😊</div>
						<div class="testi-info">
							<strong><?php echo esc_html( $name ); ?></strong>
							<span>Gurugram</span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="pricing" id="pricing">
		<div class="pricing-header">
			<div class="section-label">Pricing</div>
			<h2 class="section-title">Simple Packages</h2>
			<p class="section-sub" style="margin:0 auto;">No hidden charges. Choose what suits you.</p>
		</div>
		<div class="pricing-grid">
			<?php
			$blocks = $plans_blocks;
			if ( ! $blocks ) {
				$blocks = array(
					"Relax\n₹1,999\n60 min session\nBest for stress relief\nWhatsApp confirmation",
					"Popular ⭐\n₹2,799\n90 min session\nDeep relaxation\nMost popular",
					"Couple\n₹4,999\n90 min session for two\nSpecial occasions\nAdvance booking",
				);
			}
			foreach ( array_slice( $blocks, 0, 3 ) as $idx => $block ) :
				$lines = array_values( array_filter( array_map( 'trim', preg_split( "/\\r\\n|\\r|\\n/", $block ) ) ) );
				$title = $lines[0] ?? 'Plan';
				$price = $lines[1] ?? '₹—';
				$f1    = $lines[2] ?? '';
				$f2    = $lines[3] ?? '';
				$f3    = $lines[4] ?? '';
				$is_featured = ( 1 === $idx );
				?>
				<div class="price-card<?php echo $is_featured ? ' featured' : ''; ?>">
					<h3><?php echo esc_html( $title ); ?></h3>
					<div class="price-amount"><?php echo esc_html( $price ); ?></div>
					<div class="price-period">per session</div>
					<ul class="price-features">
						<?php if ( '' !== $f1 ) : ?><li><?php echo esc_html( $f1 ); ?></li><?php endif; ?>
						<?php if ( '' !== $f2 ) : ?><li><?php echo esc_html( $f2 ); ?></li><?php endif; ?>
						<?php if ( '' !== $f3 ) : ?><li><?php echo esc_html( $f3 ); ?></li><?php endif; ?>
					</ul>
					<a href="#contact" class="price-btn"><?php echo $is_featured ? 'Book This Plan' : 'Get Started'; ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="contact" id="contact">
		<div class="contact-inner">
			<div class="contact-info">
				<div class="section-label">Contact Us</div>
				<h2>Book Your Session</h2>
				<p>Fill the form or contact us directly. We confirm quickly on call/WhatsApp.</p>
				<div class="contact-items">
					<div class="contact-item">
						<div class="ci-icon">📞</div>
						<div class="ci-text">
							<strong><?php echo esc_html( (string) gharesva_get_setting( 'gharseva_phone', '+91 XXXXXXXXXX' ) ); ?></strong>
							<span>Call or WhatsApp us</span>
						</div>
					</div>
					<div class="contact-item">
						<div class="ci-icon">📍</div>
						<div class="ci-text">
							<strong>Gurugram, Haryana</strong>
							<span><?php echo esc_html( (string) gharesva_get_setting( 'gharseva_service_area', 'Serving all sectors in Gurugram' ) ); ?></span>
						</div>
					</div>
					<div class="contact-item">
						<div class="ci-icon">📧</div>
						<div class="ci-text">
							<strong><?php echo esc_html( (string) gharesva_get_setting( 'gharseva_email', 'info@example.com' ) ); ?></strong>
							<span>Email us your requirements</span>
						</div>
					</div>
				</div>
			</div>
			<div class="contact-form">
				<h3 style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--deep);margin-bottom:24px;">Book an Appointment</h3>
				<?php echo do_shortcode( '[gharseva_booking_form]' ); ?>
			</div>
		</div>
	</section>
</div>
<?php
get_footer();
