<?php

use Includes\Modules\MLS\FeaturedProperties;

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

$featuredProperties = new FeaturedProperties();
$listings = $featuredProperties->getUrlBuilder();

get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <?php while ( have_posts() ) : the_post(); 
            
            // get_template_part( 'template-parts/content', 'page' );
            
            endwhile; // End of the loop. ?>

            <hr>
            
            <div id="featured-properties-area">
                <div class="container-wide">
                    <div class="row justify-content-center align-items-center text-center">
                    <?php foreach($listings as $listing){ ?>
                        <div class="feat-prop col-md-6 col-xl-3 text-center">
                            <?php include(locate_template('template-parts/partials/mini-listing.php')); ?>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer();
