<?php
get_header();
?>
<main id="primary" class="site-main">
	<div class="gharseva-wrap">
		<header style="margin-bottom:18px;">
			<h1 style="margin:0 0 8px;">Services</h1>
			<p class="gh-lead" style="margin:0;">Choose a service and book your preferred slot.</p>
		</header>

		<div class="gharseva-grid">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<?php
					$price_60 = function_exists( 'get_field' ) ? get_field( 'gharseva_price_60', get_the_ID() ) : '';
					$short    = function_exists( 'get_field' ) ? (string) get_field( 'gharseva_service_short', get_the_ID() ) : '';
					?>
					<article class="gh-card">
						<h2 style="margin:0 0 8px;font-size:18px;">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<p><?php echo esc_html( '' !== $short ? $short : wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
						<p class="gh-price">
							<?php if ( '' !== $price_60 && null !== $price_60 ) : ?>
								From ₹<?php echo esc_html( number_format_i18n( (float) $price_60 ) ); ?> / 60 min
							<?php else : ?>
								Ask for pricing
							<?php endif; ?>
						</p>
						<p style="margin:0;">
							<a href="<?php the_permalink(); ?>">View details →</a>
						</p>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<p>No services found.</p>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
