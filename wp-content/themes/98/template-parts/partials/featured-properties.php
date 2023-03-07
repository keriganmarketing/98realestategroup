<?php

use Includes\Modules\MLS\NewOfficeListings;

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

$officeListings = new NewOfficeListings(258);
$searchResults  = $officeListings->getListings();
// $currentRequest = $officeListings->getCurrentRequest();
// $resultMeta     = $officeListings->getResultMeta();
// $pagination     = $officeListings->buildPagination();
$listings       = $searchResults->data;

?>
<div id="featured-properties-area">
    <div class="container-wide">
        <h2>98 Real Estate Group Listings</h2>
        <div class="row justify-content-center align-items-center text-center">
        <?php foreach(array_slice($listings, 0, 4) as $listing){ ?>
            <div class="feat-prop col-md-6 col-xl-3 text-center">
                <?php include(locate_template('template-parts/partials/mini-listing.php')); ?>
            </div>
        <?php } ?>
        </div>
        <p class="text-xs-center"><a href="/properties/our-listings/" class="btn btn-danger btn-lg"  >VIEW ALL 98 LISTINGS</a></p>
    </div>
</div>