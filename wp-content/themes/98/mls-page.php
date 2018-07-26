<?php
/**
 * Template Name: MLS Page
 *
 * @package Ninetyeight Real Estate Group
 */
get_header(); ?>

    <div id="mid">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php while ( have_posts() ) : the_post(); 
            
                get_template_part( 'template-parts/content', 'page' );
                
                endwhile; // End of the loop. ?>

                <div class="container-wide">
                    <div class="row">
                        
                    </div>
                </div>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div>
<?php get_footer();
