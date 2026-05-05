<?php
get_header();

$price_60 = function_exists( 'get_field' ) ? get_field( 'gharseva_price_60', get_the_ID() ) : '';
$price_90 = function_exists( 'get_field' ) ? get_field( 'gharseva_price_90', get_the_ID() ) : '';
$short    = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_service_short', get_the_ID() ) : '';

$benefits_raw = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_benefits', get_the_ID() ) : '';
$care_raw     = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_before_after', get_the_ID() ) : '';

$benefits = array_values( array_filter( array_map( 'trim', preg_split( "/\\r\\n|\\r|\\n/", $benefits_raw ) ) ) );
$care     = array_values( array_filter( array_map( 'trim', preg_split( "/\\r\\n|\\r|\\n/", $care_raw ) ) ) );

$book_now_url = get_permalink( 10 );
?>
<main id="primary" class="site-main">
	<div class="gharseva-wrap" style="max-width:900px;">
		<p class="gh-lead" style="margin:0 0 10px;"><a href="<?php echo esc_url( get_post_type_archive_link( 'gharseva_service' ) ); ?>" style="text-decoration:none;">← All services</a></p>
		<h1 style="margin:0 0 10px;"><?php the_title(); ?></h1>
		<?php if ( '' !== $short ) : ?>
			<p class="gh-lead" style="margin:0 0 14px;"><?php echo esc_html( $short ); ?></p>
		<?php endif; ?>

		<div class="gh-card" style="margin:18px 0;">
			<h2 style="margin:0 0 10px;font-size:18px;">Pricing</h2>
			<ul style="margin:0;padding-left:18px;">
				<li>60 min: <?php echo '' !== $price_60 && null !== $price_60 ? '₹' . esc_html( number_format_i18n( (float) $price_60 ) ) : 'Ask'; ?></li>
				<li>90 min: <?php echo '' !== $price_90 && null !== $price_90 ? '₹' . esc_html( number_format_i18n( (float) $price_90 ) ) : 'Ask'; ?></li>
			</ul>
			<p style="margin:12px 0 0;">
				<a href="<?php echo esc_url( $book_now_url ); ?>" class="gh-btn gh-btn-primary">Book this service</a>
			</p>
		</div>

		<section style="margin:18px 0;">
			<h2 style="margin:0 0 10px;font-size:18px;">Details</h2>
			<div class="gh-lead" style="opacity:.92;">
				<?php the_content(); ?>
			</div>
		</section>

		<?php if ( $benefits ) : ?>
			<section style="margin:18px 0;">
				<h2 style="margin:0 0 10px;font-size:18px;">Benefits</h2>
				<ul style="margin:0;padding-left:18px;">
					<?php foreach ( $benefits as $item ) : ?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php if ( $care ) : ?>
			<section style="margin:18px 0;">
				<h2 style="margin:0 0 10px;font-size:18px;">Before / After Care</h2>
				<ul style="margin:0;padding-left:18px;">
					<?php foreach ( $care as $item ) : ?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
