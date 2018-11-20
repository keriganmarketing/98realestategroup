<?php

use Includes\Modules\MLS\FullListing;
use Includes\Modules\Team\Team;
use Includes\Modules\MLS\Favorites;

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

$fullListing =  new FullListing();
$listing      = $fullListing->getListingInfo();

// echo '<pre>',print_r($listing),'</pre>';

$favorite     = new Favorites();
$current_user = wp_get_current_user();
$isFav        = $favorite->checkFavorites( $listing->mls_account, $current_user->ID );
$media        = $fullListing->getMedia();
$photos       = $media['photos'];
$tour         = (isset($listing->virtual_tour) ? '//' . $listing->virtual_tour : null);
$mainPhoto    = (isset($media['photos'][0]->url) ? $media['photos'][0]->url : get_template_directory_uri() . '/img/nophoto.jpg');
$location     = $listing->location;

$address      = $listing->street_num . ' ' . $listing->street_name . ' ' . $listing->city . ', ' . $listing->state . ' ' . $listing->zip;

$team = new Team();
$agent = $team->getAgentByMLS($listing->listing_agent);

//  echo '<pre>',print_r($current_user),'</pre>';

get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<div class="container-wide">

				<div class="row">
					
					<div class="property-left col-md-5">
						<div class="embed-responsive embed-responsive-16by9">
							<div class="main-prop-photo">
								<img src="<?php echo $mainPhoto; ?>" data-src="<?php echo $mainPhoto; ?>" class="img-responsive" alt="MLS Property <?php echo $listing->mls_account; ?>" />
							</div>
						</div>
						<photo-gallery 
							class="row no-gutter"
							:virtual-tour='<?php echo json_encode($tour); ?>' 
							:data-photos='<?php echo json_encode($photos); ?>'
							item-class="col-xs-6 col-lg-4 col-xl-3" ></photo-gallery>
					</div>
					<div class="property-right col-md-7">
						<div class="row">
							<div class="col-md-6">
								<h1 class="listing-page-location"><?php echo $listing->street_num.' '.$listing->street_name; ?></h1>
								<h2 class="listing-page-area"><?php echo $listing->city; ?>, FL</h2>
								<?php if($listing->status == 'Sold'){ ?>
									<h3 class="listing-page-price">Sold on <?php echo date( 'M j, Y', strtotime( $listing->sold_on )); ?> for $<?php echo number_format($listing->sold_for); ?></h3>
								<?php } else { ?>
									<?php if ( $listing->original_list_price > $listing->price && $listing->status == 'Active' && $listing->original_list_price != 0) { ?>
										<h3 class="listing-page-price"><span style="display:inline-block; padding:.25rem; font-size:1rem; border-radius:.2rem" class="bg-danger">Reduced!</span> <span style="text-decoration:line-through">$<?php echo number_format( $listing->original_list_price ); ?></span> $<?php echo number_format($listing->price); ?></h3>
									<?php } else { ?>
									<h3 class="listing-page-price">$<?php echo number_format($listing->price); ?></h3>
									<?php } ?>
								<?php } ?>
							</div>
							<div class="col-md-6">
								<div id="req-info-btn" class="text-center text-md-right">
									<form class="form form-inline" action="/contact/" method="get" style="display:inline;" >
										<input type="hidden" name="reason_for_contact" value="Property inquiry" />
										<input type="hidden" name="mls_number" value="<?php echo $listing->mls_account; ?>" />
										<?php if(isset($agent)){ ?>
										<input type="hidden" name="selected_agent" value="<?php echo $agent['slug']; ?>" />
										<?php } ?>
										<button type="submit" class="btn btn-primary mb-2 mt-5" >Request Info</button>

										<?php if ($current_user->ID != 0){ ?>
											<favorite-button 
												:icon-only="false"
												:is-fav="<?php echo ($isFav == 1 ? true : 0); ?>" 
												:mls-number="<?php echo $listing->mls_account; ?>"
												:user-id="<?php echo $current_user->ID; ?>" >
											</favorite-button>
										<?php }else{
											$redirect_to = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
											<a href="/sign-in?redirect_to=<?php echo $redirect_to; ?>" class="btn btn-danger mb-2">Sign in to save this property</a>
										<?php } ?>
										<?php if ($tour){ ?>
											<a href="<?php echo $tour; ?>" target="_blank" class="btn btn-danger">View Virtual tour</a>
										<?php } ?>
									</form>

								</div>

							</div>
						</div>
						<div class="row">
							<div class="listing-details col-xs-12">
								<p><?php echo $listing->remarks; ?></p>
							</div>
							<div class="listing-details col-md-6">
								<h3 class="left"><span>Property Details</span></h3>
								<table class="table">
								<tr><td>MLS Number</td><td><?php echo $listing->mls_account; ?></td></tr>
								<tr><td>Status</td><td><?php echo $listing->status; ?></td></tr>
								<?php if($listing->list_date != ''){ ?><tr><td>List Date</td><td><?php echo date('M d, Y', strtotime($listing->list_date)); ?></td></tr><?php } ?>
								<?php if($listing->date_modified != '' && date('Ymd', strtotime($listing->date_modified)) != date('Ymd', strtotime($listing->list_date))){ ?><tr><td>Listing Updated</td><td><?php echo  date('M d, Y', strtotime($listing->date_modified)); ?></td></tr><?php } ?>
								<?php if($listing->bedrooms != '' && $listing->bedrooms != '0'){ ?><tr><td>Bedrooms</td><td><?php echo $listing->bedrooms; ?></td></tr><?php } ?>
								<?php if($listing->total_bathrooms != '' && $listing->total_bathrooms != '0'){ ?><tr><td>Bathrooms</td><td><?php echo $listing->total_bathrooms; ?></td></tr><?php } ?>
								<?php if($listing->stories != '' && $listing->stories != '0'){ ?><tr><td>Stories</td><td><?php echo $listing->stories; ?></td></tr><?php } ?>
								<?php if($listing->acreage != '' && $listing->acreage != '0'){ ?><tr><td>Acreage</td><td><?php echo $listing->acreage; ?> Acres</td></tr><?php } ?>
								<?php if($listing->total_hc_sqft != '' && $listing->total_hc_sqft != '0'){ ?><tr><td>H/C SqFt</td><td><?php echo number_format($listing->total_hc_sqft); ?> SqFt</td></tr><?php } ?>
								<?php if($listing->sqft != '' && $listing->sqft != '0'){ ?><tr><td>Total SqFt</td><td><?php echo number_format($listing->sqft); ?> SqFt</td></tr><?php } ?>
								<?php if($listing->lot_dimensions != '' && ($listing->lot_dimensions != '0' || $listing->lot_dimensions != '')){ ?><tr><td>Lot Size</td><td><?php echo $listing->lot_dimensions; ?></td></tr><?php } ?>
								</table>
							</div>

							<div class="listing-details col-md-6">
								<h3 class="left"><span>Construction Details</span></h3>
								<table class="table">
								<?php if($listing->waterfront_feet != '' && $listing->waterfront_feet != '0'){ ?><tr><td>WF Feet</td><td><?php echo $listing->waterfront_feet; ?></td></tr><?php } ?>
								<?php if($listing->year_built != ''){ ?><tr><td>Year Built</td><td><?php echo $listing->year_built; ?></td></tr><?php } ?>
								<?php if($listing->construction != ''){ ?><tr><td>Construction Material</td><td><?php echo $listing->construction; ?></td></tr><?php } ?>
								<?php if($listing->energy != ''){ ?><tr><td>Energy, Heat/Cool</td><td><?php echo $listing->energy; ?></td></tr><?php } ?>
								<?php if($listing->exterior != ''){ ?><tr><td>Exterior Features</td><td><?php echo $listing->exterior; ?></td></tr><?php } ?>
								<?php if($listing->interior != ''){ ?><tr><td>Interior Features</td><td><?php echo $listing->interior; ?></td></tr><?php } ?>
								<?php if($listing->utilities != ''){ ?><tr><td>Utilities</td><td><?php echo $listing->utilities; ?></td></tr><?php } ?>
								<?php if($listing->parking != ''){ ?><tr><td>Parking</td><td><?php echo $listing->parking; ?></td></tr><?php } ?>
								<?php if($listing->parking_type != ''){ ?><tr><td>Parking Type</td><td><?php echo $listing->parking_type; ?></td></tr><?php } ?>
								<?php if($listing->ownership != ''){ ?><tr><td>Availability</td><td><?php echo $listing->ownership; ?></td></tr><?php } ?>
								<?php if($listing->parking_spaces != ''){ ?><tr><td>Parking Spaces</td><td><?php echo $listing->parking_spaces; ?></td></tr><?php } ?>
								<?php if($listing->ceiling_height != ''){ ?><tr><td>Ceiling Height</td><td><?php echo $listing->ceiling_height; ?></td></tr><?php } ?>
								<?php if($listing->front_footage != ''){ ?><tr><td>Front Footage</td><td><?php echo $listing->front_footage; ?></td></tr><?php } ?>
								</table>
							</div>
							<?php ob_flush(); ?>

						</div>
						<div class="row">
							<div class="listing-details col">
								<h3 class="left"><span>Area Information</span></h3>
								<table class="table">
								<?php if($listing->area != ''){ ?><tr><td>Area</td><td><?php echo $listing->area; ?></td></tr><?php } ?>
								<?php if($listing->sub_area != ''){ ?><tr><td>Sub Area</td><td><?php echo $listing->sub_area; ?></td></tr><?php } ?>
								<?php if($listing->subdivision != ''){ ?><tr><td>Subdivision</td><td><?php echo $listing->subdivision; ?></td></tr><?php } ?>
								<?php if($listing->hoa_included != ''){ ?><tr><td>HOA Includes</td><td><?php echo $listing->hoa_included; ?></td></tr><?php } ?>
								<?php if($listing->hoa_fee != '' && $listing->hoa_fee != '0'){ ?><tr><td>HOA Fee</td><td>$<?php echo number_format($listing->hoa_fee); ?></td></tr><?php } ?>
								<?php if($listing->hoa_terms != '' && $listing->hoa_terms != '0'){ ?><tr><td>HOA Term</td><td><?php echo $listing->hoa_terms; ?></td></tr><?php } ?>
								<?php if($listing->proj_name != ''){ ?><tr><td>Community</td><td><?php echo $listing->proj_name; ?></td></tr><?php } ?>
								<?php if($listing->projfacilities != ''){ ?><tr><td>Community Facilities</td><td><?php echo $listing->projfacilities; ?></td></tr><?php } ?>
								<?php if($listing->num_units != ''){ ?><tr><td>Number of Units</td><td><?php echo $listing->num_units; ?></td></tr><?php } ?>
								<?php if($listing->zoning != ''){ ?><tr><td>Zoning</td><td><?php echo $listing->zoning; ?></td></tr><?php } ?>
								<?php if($listing->lot_access != ''){ ?><tr><td>Lot Access</td><td><?php echo $listing->lot_access; ?></td></tr><?php } ?>
								<?php if($listing->lot_descriptions != ''){ ?><tr><td>Lot Description</td><td><?php echo $listing->lot_descriptions; ?></td></tr><?php } ?>
								<?php if($listing->legals != ''){ ?><tr><td>Legal Info</td><td><?php echo $listing->legals; ?></td></tr><?php } ?>
								<?php if($listing->site_description != ''){ ?><tr><td>Site Description</td><td><?php echo $listing->site_description; ?></td></tr><?php } ?>
								</table>
							</div>

							
							<div class="listing-map col">
								<h3>Map Location</h3>
								<p>Due to new roads in our area, some properties may now show up in exactly the right location.</p>
								<div class="listing-map-frame">
									<div class="embed-responsive embed-responsive-4by3">
										<div class="embed-responsive-item" id="map" style="border:1px solid #ddd;" ></div>
										<iframe 
											class="embed-responsive-item"
											frameborder="0" 
											scrolling="no" 
											marginheight="0" 
											marginwidth="0" 
											src="https://maps.google.com/maps?q=<?php echo urlencode($address); ?><?php //echo $location->lat; ?><?php //echo $location->long; ?>&hl=es;z=14&amp;output=embed"
										></iframe>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>

                <div class="row">
                    <div class="col-xs-12">
                    <?php include(locate_template('template-parts/partials/disclaimer.php')); ?>
                    </div>
                </div>

			</div>
			
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer();
