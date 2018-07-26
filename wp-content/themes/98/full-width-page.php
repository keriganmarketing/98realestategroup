<?php
/**
 * Template Name: Full-Width Page
 *
 * @package Ninetyeight Real Estate Group
 */
get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
            <?php while ( have_posts() ) : the_post(); ?>

                <div class="container-wide">

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div><!-- .entry-content -->

                    </article><!-- #post-## -->
                    
                </div>

            <?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();
