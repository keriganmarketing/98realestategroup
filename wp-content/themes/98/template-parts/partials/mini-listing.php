<?php
use Includes\Modules\Team\Team;
use Includes\Modules\MLS\Favorites;

if(date('Ymd', strtotime($listing->list_date)) >= date('Ymd', strtotime('-10 days'))){
    $isNew = TRUE;
}else{
    $isNew = FALSE;
}

$favorite     = new Favorites();
$current_user = wp_get_current_user();
$isFav        = $favorite->checkFavorites( $listing->mls_account, $current_user->ID );

$photos = $listing->media_objects->data;
$preferredPhoto = (isset($photos[0]) && $photos[0]->media_type == 'image/jpeg' ? $photos[0]->url : get_template_directory_uri() . '/img/nophoto.jpg');

?>
<div class="feat-prop-container">
    <favorite-button
        :icon-only="true"
        :is-fav="<?php echo ($isFav == 1 ? true : 0); ?>"
        :mls-number="<?php echo $listing->mls_account; ?>"
        :user-id="<?php echo $current_user->ID; ?>" >
    </favorite-button>
    <a class="listing-link" href="/listing/<?php echo $listing->mls_account; ?>"></a>
    <div class="embed-responsive embed-responsive-16by9">
        <div class="feat-prop-photo">
            <?php if ( $isNew && $listing->status == 'Active' ) { ?>
                <span class="status-flag just-listed">Just Listed</span>
            <?php } ?>
            <?php if ( $listing->status == 'Sold/Closed' ) { ?>
                <span class="status-flag sold">Sold on <?php echo date( 'M j, Y', strtotime( $listing->sold_on ) ); ?><br>
                    for $<?php echo number_format( $listing->sold_for ); ?></span>
            <?php } ?>
            <?php if ( $listing->status == 'Pending' ) { ?>
                <span class="status-flag under-contract">SALE PENDING</span>
            <?php } ?>
            <?php if ( $listing->status == 'Contingent' ) { ?>
                <span class="status-flag contingent">SALE CONTINGENT</span>
            <?php } ?>
            <?php if ( $listing->original_list_price > $listing->price && $listing->status == 'Active' && $listing->original_list_price != 0) { ?>
                <span class="status-flag reduced bg-danger">REDUCED <span style="text-decoration:line-through">$<?php echo number_format( $listing->original_list_price ); ?></span> 
                <strong>$<?php echo number_format( $listing->price); ?></strong></span>
            <?php } ?>
            <img src="<?php echo $preferredPhoto; ?>" class="img-responsive lazy"
                    alt="MLS Property <?php echo $listing->mls_account; ?> for sale in <?php echo $listing->city; ?>"/>
        </div>
    </div>
    <div class="feat-prop-info">

        <div class="feat-prop-section">
            <span
                class="addr1"><?php echo $listing->street_num . ' ' . $listing->street_name; ?></span>
            <?php if ( $listing->unit_num != '' ) { ?><span
                class="unit"><?php echo $listing->unit_num; ?></span><?php } ?>
            <br><span class="city"><?php echo $listing->city; ?></span>, <span
                class="state"><?php echo $listing->state; ?></span><br>
                <span style="font-size:12px;"><?php echo $listing->prop_type; ?></span>
        </div>

        <div class="feat-prop-section price">
        <?php if($listing->price != null) { ?>
            <p><span class="price">$<?php echo number_format($listing->price); ?></span></p>
        <?php }elseif($listing->monthly_rent){ ?>
            <p><span class="price">$<?php echo number_format($listing->monthly_rent); ?> <small>/ mo.</small></span></p>
        <?php } ?>
        </div>

        <div class="feat-prop-section">
            <div class="row">
                <?php if ( $listing->bedrooms > 0 || $listing->total_bathrooms > 0 ) { //CHECK FOR BUILDING ?>
                    <div class="col-xs-3">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/rooms.svg'; ?>" alt="rooms"
                                                class="img-responsive lazy"></span>
                        <span class="beds-num icon-data"><?php echo $listing->bedrooms; ?></span>
                        <span class="icon-label">ROOMS</span>
                    </div>
                    <div class="col-xs-3 text-xs-center">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/baths.svg'; ?>" alt="bathrooms"
                                                class="img-responsive lazy"></span>
                        <span class="baths-num icon-data"><?php echo $listing->total_bathrooms; ?></span>
                        <span class="icon-label">BATHS</span>
                    </div>
                    <div class="col-xs-3 text-xs-center">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/sqft.svg'; ?>" alt="sqft"
                                                class="img-responsive lazy"></span>
                        <span class="sqft-num icon-data"><?php echo number_format( $listing->total_hc_sqft ); ?></span>
                        <span class="icon-label">SQFT</span>
                    </div>
                    <div class="col-xs-3 text-xs-center">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/lotsize.svg'; ?>" alt="lot size"
                                                class="img-responsive lazy"></span>
                        <span
                            class="lot-dim-num icon-data"><?php echo $listing->lot_dimensions ?></span>
                        <span class="icon-label">LOT SIZE</span>
                    </div>
                <?php } else { //JUST LAND ?>
                    <div class="col-xs-6 text-xs-center">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/lotsize.svg'; ?>" alt="lot size"
                                                class="img-responsive lazy"></span>
                        <span
                            class="lot-dim-num icon-data"><?php echo str_replace( ' ', '', $listing->lot_dimensions ); ?></span>
                        <span class="icon-label">LOT SIZE</span>
                    </div>
                    <div class="col-xs-6 text-xs-center">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/acres.svg'; ?>" alt="acres"
                                                class="img-responsive lazy"></span>
                        <span class="acres-num icon-data">&nbsp;<?php echo $listing->acreage; ?>&nbsp;</span>
                        <span class="icon-label">ACRES</span>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="feat-prop-section text-xs-center">
            <span class="mlsnum">MLS# <?php echo $listing->mls_account; ?></span>
        </div>

    </div>
</div>