<?php

use Includes\Modules\MLS\FeaturedProperties;

$featuredProperties = new FeaturedProperties();
$listings = $featuredProperties->getFeaturedProp();

$tendaysago = strtotime('-10 days');
$tendaysago = date('Y-m-d',$tendaysago);

?>
<div id="featured-properties-area">
    <div class="container-wide">
        <h2>Featured Properties</h2>
        <div class="row justify-content-center align-items-center text-center">
        <?php foreach($listings as $listing){ ?>
            <div class="feat-prop col-md-6 col-xl-3 text-center">
                <?php include(locate_template('template-parts/partials/mini-listing.php')); ?>
            </div>
        <?php } ?>
        
        </div>
        <p class="text-xs-center"><a href="/properties" class="btn btn-danger btn-lg"  >ALL PROPERTIES</a></p>
    </div>
</div>