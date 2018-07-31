<?php

use Includes\Modules\MLS\QuickSearch;


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
$listings       = new QuickSearch();
$searchResults  = $listings->getSearchResults();
$currentRequest = $listings->getCurrentRequest();
$resultMeta     = $listings->getResultMeta();

get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <?php while ( have_posts() ) : the_post(); 
            
            get_template_part( 'template-parts/content', 'page' );
            
            endwhile; // End of the loop. ?>

                <div class="container">
                    <search-bar :search-terms='<?php echo $currentRequest; ?>'></search-bar>
                </div>
                <hr>
                <div class="properties grid pb-4">
                    <div class="container-wide mx-auto">
                        <div class="row justify-content-between mb-2">
                            <div class="col-sm-6">
                                <p class="small">
                                    Showing <?php echo $resultMeta->pagination->count; ?> 
                                    of <?php echo $resultMeta->pagination->total; ?> | 
                                    page <?php echo $resultMeta->pagination->current_page; ?> 
                                    of <?php echo $resultMeta->pagination->total_pages; ?> 
                            </p>
                            </div>
                            <div class="col-sm-6 text-md-right">
                                <sort-form field-value="<?php echo $listings->getSort(); ?>" :search-terms='<?php echo $currentRequest; ?>' ></sort-form>
                            </div>              
                        </div>
                        <div class="row justify-content-center">
                        <?php foreach($searchResults->data as $listing){ ?>
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
