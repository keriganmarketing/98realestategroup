<form class="navbar-form form-inline" method="post" >
	<div class="container no-gutter">
		<div class="row">
			<div class="col-lg-4">
				<p class="search-form-label">PROPERTY<br>QUICK SEARCH</p>
			</div>
			<div class="col-sm-6 col-sm-6 col-lg-2">
                <input type="text" class="form-control" name="keyword[]" placeholder="Address / MLS# / Keyword" >
			</div>
			<div class="col-sm-6 col-lg-2">
                <select class="area-select form-control" name="AREA[]" id="id-area-select" multiple="multiple">
                    <option value="any" >Any</option>
				</select>
			</div>
			<div class="col-sm-6 col-lg-2">
                <select class="prop-type-input form-control" name="listingtype[]" multiple="multiple">
                    <option value="any" >Any</option>
                </select>
			</div>
			<button type="button" class="btn btn-primary dropdown-toggle col-xs-6 col-sm-3 col-lg-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="toggler('advanced-menu');">Filter</button>
			<input type="hidden" name="cmd" value="mlssearch" >
			<button type="submit" class="btn btn-danger col-xs-6 col-sm-3 col-lg-1" >Search</button>
		</div>
	</div>
	<div id="advanced-menu" class="advanced-menu hidden col-xs-12">
		<div class="container-fluid">
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
	</div>
</form>