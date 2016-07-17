<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_attachment( get_the_ID() ) ) : // If viewing a single attachment. ?>

		<header class="entry-header">
			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="featured-media">
			<?php hybrid_attachment(); // Function for handling non-image attachments. ?>
		</div><!-- .featured-media -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

	<?php else : // If not viewing a single attachment. ?>

		<?php $image = get_the_image(
			array(
				'size'         => extant_get_featured_size(),
				'srcset_sizes' => array( extant_get_featured_size_2x() => '2x' ),
				'order'        => array( 'featured' ),
				'min_width'    => extant_get_featured_min_width(),
				'before'       => '<div class="featured-media">',
				'after'        => '</div>',
				'echo'         => false
			)
		); ?>

		<?php echo $image ? $image : extant_get_featured_fallback(); ?>

		<header class="entry-header">
			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
		</header><!-- .entry-header -->

	<?php endif; // End single attachment check. ?>

</article><!-- .entry -->
