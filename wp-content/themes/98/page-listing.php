<?php
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

if(isset($_GET['mls']) && $_GET['mls'] != ''){
	$_SESSION['mls'] = $_GET['mls'];
	$location = '/listing/'.$_GET['mls'].'/';
	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
	header("Location: $location");
}

function setogurl(){
	$pathFragments = explode('/',$_SERVER['REQUEST_URI']);
	$end = end(array_filter($pathFragments, function($value) { return $value !== ''; }));
	$mlsNum = $end;
    return $location = 'http://98realestategroup.com/listing/'.$mlsNum.'/';
}

add_filter( 'wpseo_title', 'filter_wp_title' );
add_filter( 'wpseo_opengraph_url', 'setogurl' );
add_filter( 'wpseo_canonical', 'setogurl' );
add_filter( 'wpseo_opengraph_image', 'filter_wp_mainimage');

get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<div class="container-wide">

				<div class="row">
					
					<div class="property-left col-md-5">
						<div class="embed-responsive embed-responsive-16by9">
							<div class="main-prop-photo">
								<img src="<?php echo $mainphoto; ?>" data-src="<?php echo $mainphoto; ?>" class="img-responsive" alt="MLS Property <?php echo $listing['MLS_ACCT']; ?>" />
							</div>
						</div>
						<div class="row">
							//photo gallery here
						</div>
					</div>
					<div class="property-right col-md-7">
						<div class="row">
							<div class="col-md-6">
								<h1 class="listing-page-location"><?php echo $listing['STREET_NUM'].' '.$listing['STREET_NAME']; ?></h1>
								<h2 class="listing-page-area"><?php echo $listing['CITY']; ?>, FL</h2>
								<?php if($listing['STATUS'] == 'Sold'){ ?>
									<h3 class="listing-page-price">Sold on <?php echo date( 'M j, Y', strtotime( $SOLD_DATE )); ?> for $<?php echo number_format($SOLD_PRICE); ?></h3>
								<?php } else { ?>
									<h3 class="listing-page-price">$<?php echo number_format($listing['LIST_PRICE']); ?></h3>
								<?php } ?>
							</div>
							<div class="col-md-6">
								<div id="req-info-btn" class="text-center">
									<form class="form form-inline" action="/contact/" method="get" style="display:inline;" >
										<input type="hidden" name="reason" value="requestinfo" />
										<input type="hidden" name="mls" value="<?php echo $MLS_ACCT; ?>" />
										<input type="hidden" name="la_code" value="<?php echo $LA_CODE; ?>" />
										<button type="submit" class="btn btn-primary" >Request Info</button>

										<?php if ($current_user->ID != 0){ ?>
											<?php if ( $isFav ){ ?>
												<a href="?defav=<?php echo $MLS_ACCT; ?>&referral=true" class="btn btn-primary"><img src="<?php echo getSvg( 'stared' ); ?>" alt="save to favorites" style="width: 20px; vertical-align: sub; margin: 0 3px 0 0;"> Remove from favorites</a>
												<?php }else{ ?>
												<a href="?fav=<?php echo $MLS_ACCT; ?>&referral=true" class="btn btn-danger"><img src="<?php echo getSvg( 'star' ); ?>" alt="save to favorites" style="width: 20px; vertical-align: sub; margin: 0 3px 0 0;"> Save to favorites</a>
											<?php } ?>
										<?php }else{
											$redirect_to = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
											?>
											<a href="/sign-in?redirect_to=<?php echo $redirect_to; ?>" class="btn btn-danger">Sign in to save this property</a>
										<?php } ?>

									</form>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="listing-details col-xs-12">
								<p><?php echo $REMARKS; ?></p>
							</div>
							<div class="listing-details col-md-6">
								<h3 class="left"><span>Property Details</span></h3>
								<table class="table">
								<tr><td>MLS Number</td><td><?php echo $MLS_ACCT; ?></td></tr>
								<tr><td>Status</td><td><?php echo $listing['STATUS']; ?></td></tr>
								<?php if($List_Date != ''){ ?><tr><td>List Date</td><td><?php echo date('M d, Y', $List_Date); ?></td></tr><?php } ?>
								<?php if($DATE_MODIFIED != '' && date('Ymd', $DATE_MODIFIED) != date('Ymd', $List_Date)){ ?><tr><td>Listing Updated</td><td><?php echo  date('M d, Y', $DATE_MODIFIED); ?></td></tr><?php } ?>
								<?php if($Bedrooms != '' && $Bedrooms != '0'){ ?><tr><td>Bedrooms</td><td><?php echo $Bedrooms; ?></td></tr><?php } ?>
								<?php if($Baths != '' && $Baths != '0'){ ?><tr><td>Bathrooms</td><td><?php echo $Baths; ?></td></tr><?php } ?>
								<?php if($Stories != '' && $Stories != '0'){ ?><tr><td>Stories</td><td><?php echo $Stories; ?></td></tr><?php } ?>
								<?php if($Acreage != '' && $Acreage != '0'){ ?><tr><td>Acreage</td><td><?php echo $Acreage; ?> Acres</td></tr><?php } ?>
								<?php if($TOT_HEAT_SQFT != '' && $TOT_HEAT_SQFT != '0'){ ?><tr><td>H/C SqFt</td><td><?php echo number_format($TOT_HEAT_SQFT); ?> SqFt</td></tr><?php } ?>
								<?php if($TOT_SQFT != '' && $TOT_SQFT != '0'){ ?><tr><td>Total SqFt</td><td><?php echo number_format($TOT_SQFT); ?> SqFt</td></tr><?php } ?>
								<?php if($LOT_DIMENSIONS != '' && ($LOT_DIMENSIONS != '0' || $LOT_DIMENSIONS != '')){ ?><tr><td>Lot Size</td><td><?php echo $LOT_DIMENSIONS; ?></td></tr><?php } ?>
								</table>
							</div>

							<div class="listing-details col-md-6">
								<h3 class="left"><span>Media & Files</span></h3>
								<?php
									//connect_to_media();

									$vtours = $mlsdb->getMediaType($MLS_ACCT,'Virtual Tour');
									$faxedDocs = $mlsdb->getMediaType($MLS_ACCT,'Faxed in Document');
									$files = $mlsdb->getMediaType($MLS_ACCT,'File');
									$links = $mlsdb->getMediaType($MLS_ACCT,'Hyperlink');
								?>
								<table class="table">
								<?php
									if(is_array($vtours)){
										foreach($vtours as $vtour){
											echo '<tr><td>'.$vtour['MEDIA_REMARKS'].'</td><td><a href="'.$vtour['URL'].'" target="_blank" ><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span> Open Tour</a></td></tr>';
											$vTourLink = $vtour['URL'];
										}
										$vTour = TRUE;
									}
									if(is_array($faxedDocs)){
										foreach($faxedDocs as $faxedDoc){
											echo '<tr><td>'.$faxedDoc['MEDIA_REMARKS'].'</td><td><a href="http://rafgc.net/RAFSGReports/media/'.$faxedDoc['FILE_NAME'].'" target="_blank" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Open Document</a></td></tr>';
										}
									}
									if(is_array($files)){
										foreach($files as $file){
											echo '<tr><td>'.$file['MEDIA_REMARKS'].'</td><td><a href="http://rafgc.net/RAFSGReports/media/'.$file['FILE_NAME'].'" target="_blank" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Open File</a></td></tr>';
										}
									}
									if(is_array($links)){
										foreach($links as $link){
											echo '<tr><td>'.$link['MEDIA_REMARKS'].'</td><td><a href="'.$link['URL'].'" target="_blank" ><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Open Link</a></td></tr>';
										}
									}

									ob_flush();
								?>
								</table>
							</div>
						</div>
						<div class="row">

							<div class="listing-details col-md-6">
								<h3 class="left"><span>Construction Details</span></h3>
								<table class="table">
								<?php if($WF_FEET != '' && $WF_FEET != '0'){ ?><tr><td>WF Feet</td><td><?php echo $WF_FEET; ?></td></tr><?php } ?>
								<?php if($YEAR_BUILT != ''){ ?><tr><td>Year Built</td><td><?php echo $YEAR_BUILT; ?></td></tr><?php } ?>
								<?php if($FTR_CONSTRC != ''){ ?><tr><td>Construction Material</td><td><?php echo $FTR_CONSTRC; ?></td></tr><?php } ?>
								<?php if($FTR_ENERGY != ''){ ?><tr><td>Energy, Heat/Cool</td><td><?php echo $FTR_ENERGY; ?></td></tr><?php } ?>
								<?php if($FTR_EXTERIOR != ''){ ?><tr><td>Exterior Features</td><td><?php echo $FTR_EXTERIOR; ?></td></tr><?php } ?>
								<?php if($FTR_INTERIOR != ''){ ?><tr><td>Interior Features</td><td><?php echo $FTR_INTERIOR; ?></td></tr><?php } ?>
								<?php if($FTR_UTILITIES != ''){ ?><tr><td>Utilities</td><td><?php echo $FTR_UTILITIES; ?></td></tr><?php } ?>
								<?php if($FTR_PARKING != ''){ ?><tr><td>Parking</td><td><?php echo $FTR_PARKING; ?></td></tr><?php } ?>
								<?php if($PARKING_TYPE != ''){ ?><tr><td>Parking Type</td><td><?php echo $PARKING_TYPE; ?></td></tr><?php } ?>
								<?php if($FTR_OWNERSHIP != ''){ ?><tr><td>Availability</td><td><?php echo $FTR_OWNERSHIP; ?></td></tr><?php } ?>
								<?php if($PARKING_SPACES != ''){ ?><tr><td>Parking Spaces</td><td><?php echo $PARKING_SPACES; ?></td></tr><?php } ?>
								<?php if($CIB_CEILING_HEIGHT != ''){ ?><tr><td>Ceiling Height</td><td><?php echo $CIB_CEILING_HEIGHT; ?></td></tr><?php } ?>
								<?php if($CIB_FRONT_FOOTAGE != ''){ ?><tr><td>Front Footage</td><td><?php echo $CIB_FRONT_FOOTAGE; ?></td></tr><?php } ?>
								</table>
							</div>
							<?php ob_flush(); ?>
							<div class="listing-details col-md-6">
								<h3 class="left"><span>Area Information</span></h3>
								<table class="table">
								<?php if($AREA != ''){ ?><tr><td>Area</td><td><?php echo $AREA; ?></td></tr><?php } ?>
								<?php if($SUB_AREA != ''){ ?><tr><td>Sub Area</td><td><?php echo $SUB_AREA; ?></td></tr><?php } ?>
								<?php if($SUBDIVISION != ''){ ?><tr><td>Subdivision</td><td><?php echo $SUBDIVISION; ?></td></tr><?php } ?>
								<?php if($FTR_HOAINCL != ''){ ?><tr><td>HOA Includes</td><td><?php echo $FTR_HOAINCL; ?></td></tr><?php } ?>
								<?php if($RES_HOA_FEE != '' && $RES_HOA_FEE != '0'){ ?><tr><td>HOA Fee</td><td>$<?php echo number_format($RES_HOA_FEE); ?></td></tr><?php } ?>
								<?php if($RES_HOA_TERM != '' && $RES_HOA_TERM != '0'){ ?><tr><td>HOA Term</td><td><?php echo $RES_HOA_TERM; ?></td></tr><?php } ?>
								<?php if($PROJ_NAME != ''){ ?><tr><td>Community</td><td><?php echo $PROJ_NAME; ?></td></tr><?php } ?>
								<?php if($FTR_PROJFACILITIES != ''){ ?><tr><td>Community Facilities</td><td><?php echo $FTR_PROJFACILITIES; ?></td></tr><?php } ?>
								<?php if($MAINT_FEE != '' && $MAINT_FEE != '0'){ ?><tr><td>Maintenance Fee</td><td><?php echo $MAINT_FEE; ?></td></tr><?php } ?>
								<?php if($NUM_UNITS != ''){ ?><tr><td>Number of Units</td><td><?php echo $NUM_UNITS; ?></td></tr><?php } ?>
								<?php if($FTR_ZONING != ''){ ?><tr><td>Zoning</td><td><?php echo $FTR_ZONING; ?></td></tr><?php } ?>
								<?php if($FTR_LOTACCESS != ''){ ?><tr><td>Lot Access</td><td><?php echo $FTR_LOTACCESS; ?></td></tr><?php } ?>
								<?php if($FTR_LOTDESC != ''){ ?><tr><td>Lot Description</td><td><?php echo $FTR_LOTDESC; ?></td></tr><?php } ?>
								<?php if($LEGALS != ''){ ?><tr><td>Legal Info</td><td><?php echo $LEGALS; ?></td></tr><?php } ?>
								<?php if($FTR_SITEDESC != ''){ ?><tr><td>Site Description</td><td><?php echo $FTR_SITEDESC; ?></td></tr><?php } ?>
								</table>
							</div>

							<div class="clearfix"></div>
							<div class="listing-map col-xs-12">
								<h3>Map Location</h3>
								<p>Due to new roads in our area, some properties may now show up in exactly the right location.</p>
								<div class="listing-map-frame">
									<div class="embed-responsive embed-responsive-4by3">
										<div class="embed-responsive-item" id="map" ></div>
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
