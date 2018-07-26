<a id="quick-contact-form" class="pad-anchor"></a>
<form class="form leadform" name="quoteform" id="mainForm" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="formID" value="homeval" >
    
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group sell-property">
                <span class="pull-sm-right"><span class="req">*</span> = required</span>
                <h2><span>Contact Information</span></h2>
                <hr />
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-6 form-group">    										
            <label for="yourname" class="control-label">Name<span class="req">*</span></label>
            <input type="text" class="form-control" value="" name="yourname" required >
        </div>
        <div class="col-md-6 form-group">
            <label for="email" class="control-label">Email<span class="req">*</span></label>
            <input type="text" class="form-control" value="" name="youremail" required >
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group form-inline <?php //if(($ph1 == '' || $ph2 == '' || $ph3 == '' || strlen($ph1)< 3 || strlen($ph2)< 3 || strlen($ph3)< 4 ) && $_POST && $_POST['cform']=='sell'){ echo 'has-error'; } ?>">
            <label for="phone1" class="control-label">Phone</label>
            <input type="tel" class="phoneinput form-control" name="phone1" id="phone1" maxlength="3" style="width:60px; display:inline-block !important;" >
            <input type="tel" class="phoneinput form-control" name="phone2" id="phone2" maxlength="3" style="width:60px; display:inline-block !important;" >
            <input type="tel" class="phoneinput form-control" name="phone3" id="phone3" maxlength="4" style="width:70px; display:inline-block !important;" >
        </div>
        
        <div class="col-md-4 form-group">    										
            <label for="name" class="control-label">Your Agent<span class="req">*</span></label>
            <select class="form-control" name="youragent">
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group sell-property">
            <h2><span>Property Information</span></h2>
            <hr />
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-8 form-group" id="addr1">
                    <label for="youraddr1" class="control-label">Listing Address<span class="req">*</span></label>
                    <input type="text" class="form-control" value="" placeholder="Street" name="youraddr1" required>
                </div>
                <div class="col-sm-4 form-group" id="addr2">
                    <label>&nbsp;</label>
                    <input type="text" class="form-control" value="" placeholder="Apt/Suite" name="youraddr2" required>
                </div>
                <div class="col-xs-7 col-sm-5 form-group" id="city">
                    <input type="text" class="form-control" value="" placeholder="City" name="yourcity" required>
                </div>
                <div class="col-xs-6 col-sm-4 form-group" id="state">
                    <select class="form-control" name="yourstate">
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>		
                </div>
                <div class="col-xs-4 col-sm-3 form-group" id="zip">
                    <input type="text" class="form-control" value="" placeholder="ZIP Code" name="yourzip" required>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <label for="numBathrooms" class="control-label">Property Type<span class="req">*</span></label>
                <label class="radio-inline"><input type="radio" name="propertyType" id="proptype1" value="Residential"> Residential</label>
                <label class="radio-inline"><input type="radio" name="propertyType" id="proptype2" value="Commercial"> Commercial</label>
                <label class="radio-inline"><input type="radio" name="propertyType" id="proptype3" value="Condo"> Condo</label>
                <label class="radio-inline"><input type="radio" name="propertyType" id="proptype4" value="Lot/Land"> Lot/Land</label>
            </div>
        </div>
    </div>
  
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <label for="pdetails" class="control-label">Property Details</label>
                <textarea class="form-control" name="pdetails"></textarea>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-sm-3 form-group">&nbsp;</div>
    </div>
    <div class="row">
        <div id="listing-request" class="col-xs-12">
            <div class="form-group">
            <input type="text" name="secu" value="" style="position:absolute; height:1px; width:1px; top:-10000px; left:-10000px;">
                <button type="submit" class="btn btn-primary btn-lg" value="Submit Valuation Request">Submit Valuation Request<span class="glyphicon glyphicon-chevron-right"></span></button>
            </div>
        </div>
    </div>

</form>