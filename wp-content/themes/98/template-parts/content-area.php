<?php

use Includes\Modules\MLS\AreaListings;

/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ninetyeight Real Estate Group
 */

$hero_image = get_field('hero_image');
$image1 = get_field('image_1');
$image2 = get_field('image_2');
$image3 = get_field('image_3');
$image4 = get_field('image_4');
$photos =[
    ['url' => $image1],
    ['url' => $image2],
    ['url' => $image3],
    ['url' => $image4] 
]; 
$area = get_field('db_name');

$areaListings       = new AreaListings($area);
$searchResults      = $areaListings->getListings();
$currentRequest     = $areaListings->getCurrentRequest();
$resultMeta         = $areaListings->getResultMeta();
$listings           = $searchResults->data;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container-wide">
        <div class="row">
            <div class="property-left col-md-4 no-gutter area-info-pictures">
                <div class="row" >
                    <div class="col-xs-12">
                        <div class="embed-responsive embed-responsive-16by9" style="margin:0;">
                            <div class="main-prop-photo">
                                <img src="<?php echo $hero_image; ?>" data-src="<?php echo $hero_image; ?>" class="img-responsive" alt="Area Photo" />
                            </div>
                        </div>
                    </div>
                    <photo-gallery :data-photos='<?php echo json_encode($photos); ?>' item-class="hidden-sm-down col-md-6" ></photo-gallery>
                </div>
                <div class="row">
                    <div id="TA_selfserveprop860" class="TA_selfserveprop offset-sm-1 col-sm-11" style="margin-bottom:20px;">
                        <ul id="DikDXAD3cl" class="TA_links 9NehdOp5JAA">
                            <li id="U8ZH6Jh4x" class="V2TeMLaESdzO">
                                <a target="_blank" href="https://www.tripadvisor.com/"><img src="https://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png" alt="TripAdvisor"/></a>
                            </li>
                        </ul>
                    </div>
                    <?php
                    $locationId = $post->ID;                    
                    $areaArray = array(
                        49 => '34437',
                        51 => '34578',
                        55 => '34578',
                        47 => '1483771',
                        45 => '1483771',
                        53 => '1483771'
                    );
                    ?> 
                    <script src="https://www.jscache.com/wejs?wtype=selfserveprop&uniq=860&locationId=<?php echo $areaArray[$locationId]; ?>&lang=en_US&rating=true&nreviews=4&writereviewlink=true&popIdx=false&iswide=true&border=false&display_version=2"></script>
                  
                </div>
            </div>
            <div class="col-md-7">
                <div class="entry-content area-content">
                    <?php if(isset($listings) > 0){ ?>
                    <a id="btn-view-area-listing" class="btn btn-primary pull-md-right" href="#area-listings" >View Area Listings</a>
                    <?php } ?>
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </div>
        </div>
    </div>
</article><!-- #post-## -->
<div class="container-wide">
    <hr>
</div>

<?php if(isset($listings) > 0){ ?>
<a name="area-listings"></a>
<div class="properties grid pb-4">
    <div class="container-wide">
        <div class="row justify-content-between mb-4">
            <div class="col-sm-8">
                <sort-form field-value="<?php echo $areaListings->getSort(); ?>" :search-terms='<?php echo $currentRequest; ?>' ></sort-form>
                <filter-form :hide-area="true" field-value="<?php echo $areaListings->getSort(); ?>" :search-terms='<?php echo $currentRequest; ?>' ></filter-form>
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
        <?php $areaListings->buildPagination(); ?>
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