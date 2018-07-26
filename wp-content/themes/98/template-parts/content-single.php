<?php
/**
 * Template part for displaying single posts.
 * @package Ninetyeight Real Estate Group
 */

?>

<article id="post-<?php the_ID(); ?>" class="article" >
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta">
			<p><?php ninetyeight_posted_on(); ?></p>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

