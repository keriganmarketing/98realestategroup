<?php

use Includes\Modules\MLS\MapSearch;
use function GuzzleHttp\json_encode;

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

$listings       = new MapSearch();
$searchResults  = $listings->getSearchResults();
$currentRequest = $listings->getCurrentRequest();
get_header(); 
?>
<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            
			<?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12" >
                                <div class="map-key col-md-4 pull-md-right"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/residential-label.png" alt="Residential"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/land-label.png" alt="Lots/Land"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/commercial-label.png" alt="Commercial"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/contingent-label.png" alt="Contingent/Pending"><img class="key-pin" src="<?php echo get_template_directory_uri(); ?>/img/sold-label.png" alt="Sold"></div>
                                <div class="entry-content full-width">
                                    <?php the_content(); ?>
                                </div><!-- .entry-content -->
                            </div>
                        </div>
                    </div>
                </article><!-- #post-## -->

            <?php endwhile; // End of the loop. ?>
            
            <div class="container-wide">
                <search-bar :search-terms='<?php echo $currentRequest; ?>'></search-bar>
                <hr>
                <?php if(isset($searchResults->data) > 0){ ?>
                <google-map 
                    :latitude="29.862642" 
                    :longitude="-85.329176" 
                    :zoom="10" 
                    :search-terms='<?php echo $currentRequest; ?>'
                    api="<?php echo GOOGLE_MAPS_API; ?>"
                ></google-map>
                
                <?php include(locate_template('template-parts/partials/disclaimer.php')); ?>

            </div>
            <?php }else{ ?>
                <div class="container">
                    <p>There were no properties found using your search criteria. Please broaden your search and try again.</p>
                </div>
            <?php } ?>
            &nbsp;
		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();