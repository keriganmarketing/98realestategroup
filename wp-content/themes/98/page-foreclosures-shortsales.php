<?php

use Includes\Modules\MLS\Foreclosures;

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

$foreclosures       = new Foreclosures();
$searchResults      = $foreclosures->getListings();
$currentRequest     = $foreclosures->getCurrentRequest();
$resultMeta         = $foreclosures->getResultMeta();
$listings           = $searchResults->data;

get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <?php while ( have_posts() ) : the_post(); 
            
            get_template_part( 'template-parts/content', 'page' );
            
            endwhile; // End of the loop. ?>

            <div class="container-wide">
                <hr>
            </div>
            
            <?php if(isset($listings) > 0){ ?>
            <div class="properties grid pb-4">
                <div class="container-wide">
                    <div class="row justify-content-between mb-4">
                        <div class="col-sm-8">
                            <sort-form field-value="<?php echo $foreclosures->getSort(); ?>" :search-terms='<?php echo $currentRequest; ?>' ></sort-form>
                            <filter-form field-value="<?php echo $foreclosures->getSort(); ?>" :search-terms='<?php echo $currentRequest; ?>' ></filter-form>
                            <small class="text-muted" style="display:inline; padding-left:10px;" >
                                Showing <?php echo $resultMeta->count; ?> 
                                of <?php echo $resultMeta->total; ?> | 
                                page <?php echo $resultMeta->current_page; ?> 
                                of <?php echo $resultMeta->total_pages; ?> 
                            </small>
                        </div>
                        <div class="col-sm-4 text-md-right">
                            
                        </div>     
                    </div>
                </div>
                <div class="container-wide mx-auto">
                    <div class="row justify-content-center">
                    <?php foreach($searchResults->data as $listing){ ?>
                        <div class="feat-prop col-md-6 col-xl-3 text-center">
                            <?php include(locate_template('template-parts/partials/mini-listing.php')); ?>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <div class="container mx-auto text-xs-center">
                <div class="pb-4">
                    <?php $foreclosures->buildPagination(); ?>
                </div>
                <hr>
                <div class="pb-4">
                    <?php include(locate_template('template-parts/partials/disclaimer.php')); ?>
                </div>
            </div>
            <?php }else{ ?>
            <div class="container">
                <p>There were no properties found using your search criteria. Please broaden your search and try again.</p>
            </div>
            <?php } ?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer();
