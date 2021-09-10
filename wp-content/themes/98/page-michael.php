<?php

use Includes\Modules\MLS\SoldListings;

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

use Includes\Modules\MLS\HotDeals;

$hotDeals = new HotDeals();

$searchResults  = $hotDeals->getHotProp();
$currentRequest = $hotDeals->getCurrentRequest();
$resultMeta     = $hotDeals->getResultMeta();
$pagination     = $hotDeals->buildPagination();
$listings       = $searchResults->data;

//echo '<pre>',print_r($searchResults),'</pre>';

$tendaysago = strtotime('-10 days');
$tendaysago = date('Y-m-d',$tendaysago);

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
            
            <?php if(isset($searchResults->data) > 0){ ?>
            <div class="properties grid pb-4">
                <div class="container-wide">
                    <div class="row justify-content-between mb-4">
                        <div class="col-sm-6">
                            <small class="text-muted">
                                Showing <?php echo $resultMeta->count; ?>
                                of <?php echo $resultMeta->total; ?> |
                                page <?php echo $resultMeta->current_page; ?>
                                of <?php echo $resultMeta->total_pages; ?>
                            </small>
                        </div>
                        <div class="col-sm-6 text-md-right">
                            <sort-form field-value="<?php echo $hotDeals->getSort(); ?>" :search-terms='<?php echo $currentRequest; ?>' ></sort-form>
                        </div>
                    </div>
                </div>
                <div class="container-wide mx-auto">

                    <div class="row justify-content-center align-items-center text-center">
                    <?php foreach($listings as $listing){ ?>
                        <div class="feat-prop col-md-6 col-xl-3 text-center">
                            <?php include(locate_template('template-parts/partials/mini-listing.php')); ?>
                        </div>
                    <?php } ?>
                    </div>

                </div>
            </div>
            <div class="container mx-auto text-xs-center">
                <?php if($hotDeals->resultsArePaginated()){ ?>
                    <div class="pb-4">
                        <?php echo $pagination; ?>
                    </div>
                <?php } ?>
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
