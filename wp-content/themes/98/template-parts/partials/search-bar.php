<form class="navbar-form form-inline" method="post" action="/properties/" >
    <div class="row">
        <div class="col-sm-6 col-sm-6 col-lg-3">
            <label>Keyword</label>
            <input type="text" class="form-control" name="keyword[]" placeholder="Address / MLS# / Community" <?php echo (isset($keywords) && $keywords != '' ? 'value="'.$keywords.'"' : ''); ?> >
        </div>
        <div class="col-sm-6 col-lg-3">
            <label>City / Area</label>
            <select class="area-select form-control" name="AREA[]" id="id-area-select" multiple="multiple">
                <option value="any" >Any</option>
            </select>
        </div>
        <div class="col-sm-6 col-lg-3">
            <label>Property Type</label>
            <select class="prop-type-input form-control" name="listingtype[]" multiple="multiple">
                <option value="any" >Any</option>
            </select>
        </div>
        <div class="col-sm-6 col-lg-3">
            <label class="col-xs-12">&nbsp;</label>
            <button type="button" class="btn btn-primary dropdown-toggle col-xs-8 col" aria-haspopup="true" aria-expanded="false" >Advanced Options</button>
            <input type="hidden" name="cmd" value="mlssearch" >
            <button type="submit" class="btn btn-danger col-xs-4 col" >Search</button>
        </div>
    </div>
    <div id="advanced-menu" class="advanced-menu hidden col-xs-12">
        <div class="row">
            <div class="col-md-4 col-lg-6">
                <div class="row">
                    <div class="col-xs-6 col-md-12 col-lg-6">
                        <label>Property Status</label>
                    </div>
                    <div class="col-xs-6 col-md-12 col-lg-6">
                        <label>Property Details</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-12 col-lg-6">
                        <label>Min Price</label>
                    </div>
                    <div class="col-xs-6 col-md-12 col-lg-6">
                        <label>Max Price</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-12 col-lg-6">
                        <label>Total Sqft</label>
                    </div>
                    <div class="col-xs-6 col-md-12 col-lg-6">
                        <label>Acreage</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label>Beds</label>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label>Baths</label>
            </div>
        </div>
    </div>
</form>