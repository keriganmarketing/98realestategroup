<?php
/**
 * The blog template file.
 * @package Ninetyeight Real Estate Group
 */

get_header(); ?>

<div id="mid">
    <div id="primary" class="content-area page">
        <main id="main" class="site-main" role="main"> 
            <div class="container">
                <div class="entry-content">
                    <h1 class="entry-title">Real Estate Market News</h1>
                    
                    <?php if ( have_posts() ) : ?>
           
                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            
                            <?php get_template_part( 'template-parts/content', get_post_format() ); ?>
            
                        <?php endwhile; ?>
                        
                    <?php endif; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </main><!-- #main -->
	</div>
</div>

<?php get_footer(); ?>
