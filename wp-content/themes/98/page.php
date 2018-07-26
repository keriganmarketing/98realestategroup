<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ninetyeight Real Estate Group
 */


get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
            <?php
            while ( have_posts() ) : the_post();

            if(get_field('hero_image') && $post->ID != 57 && $post->ID != 59)
                get_template_part( 'template-parts/content', 'area' );
            else
                get_template_part( 'template-parts/content', 'page' );

            endwhile; // End of the loop.
            ?>

            <?php //getTemplateFile('home-valuation-form'); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();
