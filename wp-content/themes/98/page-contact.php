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

                get_template_part( 'template-parts/content', 'page' );

            endwhile; // End of the loop.
            ?>

            <?php //getTemplateFile('home-valuation-form'); ?>
                        
            <div class="request-info-form">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-10 offset-lg-1" >
                            <?php include(locate_template('template-parts/forms/request-info.php'));?>
                        </div>
                    </div>
                </div>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();
