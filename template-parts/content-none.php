<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: pranontheme
 * Website: http://webpentagon.com/
 */
?>

<section class="no-results not-found">
	<div class="page-header">
		<h1><?php _e( 'Nothing Found', 'yowel' ); ?></h1>
	</div><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'yowel' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'yowel' ); ?></p>
            <?php echo Wpbucket_Partials::wpbucket_get_content_serch_form();?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'yowel' ); ?></p>
            <?php echo Wpbucket_Partials::wpbucket_get_content_serch_form();?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
