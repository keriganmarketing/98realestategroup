<?php

if($listing->list_date >= $tendaysago){
    $isNew = TRUE;
}else{
    $isNew = FALSE;
}

?>
<div class="feat-prop-container">    
    <a class="listing-link" href="/listing/?mls=<?php echo $listing->mls_account; ?>"></a>
    <div class="embed-responsive embed-responsive-16by9">
        <div class="feat-prop-photo">
            <?php if ( $isNew && $listing->status == 'Active' ) { ?>
                <span class="status-flag just-listed">Just Listed</span>
            <?php } ?>
            <?php if ( $listing->status == 'Sold' ) { ?>
                <span class="status-flag sold">Sold on <?php echo date( 'M j, Y', strtotime( $listing->sold_date ) ); ?>
                    for $<?php echo number_format( $listing->sold_price ); ?></span>
            <?php } ?>
            <?php if ( $listing->status == 'Pending' ) { ?>
                <span class="status-flag under-contract">SALE PENDING</span>
            <?php } ?>
            <?php if ( $listing->status == 'Contingent' ) { ?>
                <span class="status-flag contingent">SALE CONTINGENT</span>
            <?php } ?>
            <img src="<?php echo $listing->preferred_image; ?>" class="img-responsive lazy"
                    alt="MLS Property <?php echo $listing->mls_account; ?> for sale in <?php echo $listing->city; ?>"/>
        </div>
    </div>
    <div class="feat-prop-info">

        <div class="feat-prop-section">
            <span
                class="addr1"><?php echo $listing->street_number . ' ' . $listing->street_name; ?></span>
            <?php if ( $listing->unit_number != '' ) { ?><span
                class="unit"><?php echo $listing->unit_number; ?></span><?php } ?>
            <br><span class="city"><?php echo $listing->city; ?></span>, <span
                class="state"><?php echo $listing->state; ?></span><br>
                <span style="font-size:12px;"><?php echo $listing->property_type; ?></span>
        </div>

        <div class="feat-prop-section price">
            <p><span class="price">$<?php echo number_format( $listing->price ); ?></span></p>
        </div>

        <div class="feat-prop-section">
            <div class="row">
                <?php if ( $listing->class == 'A' ) { //RESIDENTIAL LISTINGS ?>
                    <div class="col-xs-3 text-xs-center">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/beds.svg'; ?>" alt="bedrooms"
                                                class="img-responsive lazy"></span>
                        <span class="baths-num icon-data"><?php echo $listing->bedrooms; ?></span>
                        <span class="icon-label">BEDS</span>
                    </div>
                    <div class="col-xs-3 text-xs-center">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/baths.svg'; ?>" alt="bathrooms"
                                                class="img-responsive lazy"></span>
                        <span class="baths-num icon-data"><?php echo $listing->bathrooms; ?></span>
                        <span class="icon-label">BATHS</span>
                    </div>
                    <div class="col-xs-3 text-xs-center">
                        <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/sqft.svg'; ?>" alt="sqft"
                                                class="img-responsive lazy"></span>
                        <span class="baths-num icon-data"><?php echo number_format( $listing->sq_ft ); ?></span>
                        <span class="icon-label">SQFT</span>
                    </div>
                    <?php if ( $listing->property_type == 'Condominiums' || strpos( $listing->property_type, 'ASF' ) !== false ) { //CONDO OR MULTI ?>
                        <div class="col-xs-3 text-xs-center">
                            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/parking.svg'; ?>" alt="parking spaces" class="img-responsive lazy" ></span>
                            <span
                                class="baths-num icon-data"><?php echo $listing->parking_spaces ?></span>
                            <span class="icon-label">PARKING</span>
                        </div>
                    <?php } else { //HOUSE ?>
                        <div class="col-xs-3 text-xs-center">
                            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/acres.svg'; ?>" alt="acres"
                                                    class="img-responsive lazy"></span>
                            <span class="baths-num icon-data"><?php echo $listing->acreage; ?></span>
                            <span class="icon-label">ACRES</span>
                        </div>
                    <?php } ?>
                <?php } elseif ( $listing->class == 'C' ) { //LOTS & LAND ?>
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

                        <span class="acres-num icon-data"><?php echo $listing->acreage; ?></span>
                        <span class="icon-label">ACRES</span>
                    </div>
                <?php } else { //COMMERCIAL LISTINGS ?>
                    <?php if ( $listing->bedrooms > 0 || $listing->bathrooms > 0 ) { //CHECK FOR BUILDING ?>
                        <div class="col-xs-3">
                            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/rooms.svg'; ?>" alt="rooms"
                                                    class="img-responsive lazy"></span>
                            <span class="beds-num icon-data"><?php echo $listing->bedrooms; ?></span>
                            <span class="icon-label">ROOMS</span>
                        </div>
                        <div class="col-xs-3 text-xs-center">
                            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/baths.svg'; ?>" alt="bathrooms"
                                                    class="img-responsive lazy"></span>
                            <span class="baths-num icon-data"><?php echo $listing->bathrooms; ?></span>
                            <span class="icon-label">BATHS</span>
                        </div>
                        <div class="col-xs-3 text-xs-center">
                            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/img/sqft.svg'; ?>" alt="sqft"
                                                    class="img-responsive lazy"></span>
                            <span class="sqft-num icon-data"><?php echo number_format( $listing->sq_ft ); ?></span>
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
                            <span class="acres-num icon-data"><?php echo $listing->acreage; ?></span>
                            <span class="icon-label">ACRES</span>
                        </div>
                    <?php } ?>
                <?php } ?>

            </div>
        </div>

        <div class="feat-prop-section text-xs-center">
            <span class="mlsnum">MLS# <?php echo $listing->mls_account; ?></span>
        </div>

    </div>
</div>