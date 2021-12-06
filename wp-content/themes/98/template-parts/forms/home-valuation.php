<?php

use Includes\Modules\Team\Team;
use Includes\Modules\Leads\HomeValuation;

//DEFAULT FORM VARS
$yourname            = (isset($_GET['full_name']) ? $_GET['full_name'] : '');
$youremail           = (isset($_GET['email_address']) ? $_GET['email_address'] : '');
$phone               = (isset($_GET['phone_number']) ? $_GET['phone_number'] : '');
$reason              = (isset($_GET['reason_for_contact']) ? $_GET['reason_for_contact'] : '');
$mlsnumber           = (isset($_GET['mls_number']) ? $_GET['mls_number'] : '');
$agentOptions        = '';
$listing_state       = '';

//IS USER LOGGED IN?
$currentUser            = get_user_meta( get_current_user_id() );
$currentUserInfo        = get_userdata( get_current_user_id() );
$yourname               = (is_array($currentUser) && $currentUser['first_name'][0] != '' ? $currentUser['first_name'][0] : $yourname);
$yourname               = (is_array($currentUser) && $currentUser['last_name'][0] != '' ? $yourname.' '.$currentUser['last_name'][0] : $yourname);
$youremail              = ($currentUserInfo && isset($currentUserInfo->user_email) ? $currentUserInfo->user_email : $youremail);
$phone                  = (is_array($currentUser) && isset($currentUser['phone1'][0]) ? $currentUser['phone1'][0] : $phone);

$selectedAgent = (isset($_GET['selected_agent']) ? $_GET['selected_agent'] : null); //IF GET, then override.
$selectedAgent = (is_array($currentUser) && isset($currentUser['your_agent'][0]) && $currentUser['your_agent'][0] != '' ? $currentUser['your_agent'][0] : $selectedAgent ); //get agent from user data.
$selectedAgent = (isset($_GET['selected_agent']) && isset($_GET['reason']) && $_GET['reason'] == 'Just reaching out' ? $_GET['selected_agent'] : $selectedAgent ); //IF GET and from team, then override.

//SELECT OPTIONS
$agents     = new Team();
$agentArray = $agents->getTeam();
foreach($agentArray as $agent){
    if($agent['slug'] != 'kristy-lee'){
	    $agentOptions .= '<option value="'.$agent['name'].'" '.($selectedAgent == $agent['slug'] ? 'selected' : '').' >'.$agent['name'].'</option>';
    }
}

$formID                 = (isset($_POST['formID']) ? $_POST['formID'] : '');
$securityFlag           = (isset($_POST['secu']) ? $_POST['secu'] : '');
$formSubmitted          = ($formID == 'homevaluation' && $securityFlag == '' ? TRUE : FALSE);

if( $formSubmitted ){ //FORM WAS SUBMITTED

    $leads = new HomeValuation();
    $leads->handleLead($_POST);

}
?>
<a id="homeval" class="pad-anchor"></a>
<form class="form leadform" name="quoteform" id="mainForm" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="formID" value="homevaluation" >
    <input type="hidden" name="user_agent" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" >
    <input type="hidden" name="ip_address" value="<?php echo (new Includes\Modules\Leads\Leads())->getIP(); ?>" >
    <input type="hidden" name="referrer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" >
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
            <label for="full_name" class="control-label">Name<span class="req">*</span></label>
            <input type="text" class="form-control <?php echo ( $yourname && $formSubmitted ? 'has-error' : ''); ?>" value="<?php echo ($yourname != '' ? $yourname : ''); ?>" value="" name="full_name" required >
        </div>
        <div class="col-md-6 form-group">
            <label for="email" class="control-label">Email<span class="req">*</span></label>
            <input type="text" class="form-control <?php echo( $youremail=='' && $formSubmitted ? 'has-error' : ''); ?>" value="" name="email_address" required >
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group form-inline">
            <label for="phone1" class="control-label">Phone</label>
            <input name="phone_number" type="text" id="phone" class="textbox form-control <?php echo ( $phone && $formSubmitted ? 'has-error' : ''); ?>" value="<?php echo ($phone != '' ? $phone : ''); ?>" placeholder="(###)###-###) *">
        </div>
        
        <div class="col-md-4 form-group <?php echo ( $selectedAgent=='' && $formSubmitted ? 'has-error' : ''); ?>">    										
            <label for="name" class="control-label">Your Agent<span class="req">*</span></label>
            <select class="form-control" name="selected_agent">
                <option value="" >First Available</option>
                <?php echo $agentOptions; ?>
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
                    <input type="text" class="form-control" value="" placeholder="Street" name="listing_address" required>
                </div>
                <div class="col-sm-4 form-group" id="addr2">
                    <label>&nbsp;</label>
                    <input type="text" class="form-control" value="" placeholder="Apt/Suite" name="listing_address_2">
                </div>
                <div class="col-xs-7 col-sm-5 form-group" id="city">
                    <input type="text" class="form-control" value="" placeholder="City" name="listing_city" required>
                </div>
                <div class="col-xs-6 col-sm-4 form-group" id="state">
                    <select class="form-control" required name="listing_state">
                        <option value="AL" <?php if($listing_state == 'AL'){ echo 'selected'; } ?> >Alabama</option>
                        <option value="AK" <?php if($listing_state == 'AK'){ echo 'selected'; } ?> >Alaska</option>
                        <option value="AZ" <?php if($listing_state == 'AZ'){ echo 'selected'; } ?> >Arizona</option>
                        <option value="AR" <?php if($listing_state == 'AR'){ echo 'selected'; } ?> >Arkansas</option>
                        <option value="CA" <?php if($listing_state == 'CA'){ echo 'selected'; } ?> >California</option>
                        <option value="CO" <?php if($listing_state == 'CO'){ echo 'selected'; } ?> >Colorado</option>
                        <option value="CT" <?php if($listing_state == 'CT'){ echo 'selected'; } ?> >Connecticut</option>
                        <option value="DE" <?php if($listing_state == 'DE'){ echo 'selected'; } ?> >Delaware</option>
                        <option value="FL" <?php if($listing_state == 'FL' || $listing_state == ''){ echo 'selected'; } ?> >Florida</option>
                        <option value="GA" <?php if($listing_state == 'GA'){ echo 'selected'; } ?> >Georgia</option>
                        <option value="HI" <?php if($listing_state == 'HI'){ echo 'selected'; } ?> >Hawaii</option>
                        <option value="ID" <?php if($listing_state == 'ID'){ echo 'selected'; } ?> >Idaho</option>
                        <option value="IL" <?php if($listing_state == 'IL'){ echo 'selected'; } ?> >Illinois</option>
                        <option value="IN" <?php if($listing_state == 'IN'){ echo 'selected'; } ?> >Indiana</option>
                        <option value="IA" <?php if($listing_state == 'IA'){ echo 'selected'; } ?> >Iowa</option>
                        <option value="KS" <?php if($listing_state == 'KS'){ echo 'selected'; } ?> >Kansas</option>
                        <option value="KY" <?php if($listing_state == 'KY'){ echo 'selected'; } ?> >Kentucky</option>
                        <option value="LA" <?php if($listing_state == 'LA'){ echo 'selected'; } ?> >Louisiana</option>
                        <option value="ME" <?php if($listing_state == 'ME'){ echo 'selected'; } ?> >Maine</option>
                        <option value="MD" <?php if($listing_state == 'MD'){ echo 'selected'; } ?> >Maryland</option>
                        <option value="MA" <?php if($listing_state == 'MA'){ echo 'selected'; } ?> >Massachusetts</option>
                        <option value="MI" <?php if($listing_state == 'MI'){ echo 'selected'; } ?> >Michigan</option>
                        <option value="MN" <?php if($listing_state == 'MN'){ echo 'selected'; } ?> >Minnesota</option>
                        <option value="MS" <?php if($listing_state == 'MS'){ echo 'selected'; } ?> >Mississippi</option>
                        <option value="MO" <?php if($listing_state == 'MO'){ echo 'selected'; } ?> >Missouri</option>
                        <option value="MT" <?php if($listing_state == 'MT'){ echo 'selected'; } ?> >Montana</option>
                        <option value="NE" <?php if($listing_state == 'NE'){ echo 'selected'; } ?> >Nebraska</option>
                        <option value="NV" <?php if($listing_state == 'NV'){ echo 'selected'; } ?> >Nevada</option>
                        <option value="NH" <?php if($listing_state == 'NH'){ echo 'selected'; } ?> >New Hampshire</option>
                        <option value="NJ" <?php if($listing_state == 'NJ'){ echo 'selected'; } ?> >New Jersey</option>
                        <option value="NM" <?php if($listing_state == 'NM'){ echo 'selected'; } ?> >New Mexico</option>
                        <option value="NY" <?php if($listing_state == 'NY'){ echo 'selected'; } ?> >New York</option>
                        <option value="NC" <?php if($listing_state == 'NC'){ echo 'selected'; } ?> >North Carolina</option>
                        <option value="ND" <?php if($listing_state == 'ND'){ echo 'selected'; } ?> >North Dakota</option>
                        <option value="OH" <?php if($listing_state == 'OH'){ echo 'selected'; } ?> >Ohio</option>
                        <option value="OK" <?php if($listing_state == 'OK'){ echo 'selected'; } ?> >Oklahoma</option>
                        <option value="OR" <?php if($listing_state == 'OR'){ echo 'selected'; } ?> >Oregon</option>
                        <option value="PA" <?php if($listing_state == 'PA'){ echo 'selected'; } ?> >Pennsylvania</option>
                        <option value="RI" <?php if($listing_state == 'RI'){ echo 'selected'; } ?> >Rhode Island</option>
                        <option value="SC" <?php if($listing_state == 'SC'){ echo 'selected'; } ?> >South Carolina</option>
                        <option value="SD" <?php if($listing_state == 'SD'){ echo 'selected'; } ?> >South Dakota</option>
                        <option value="TN" <?php if($listing_state == 'TN'){ echo 'selected'; } ?> >Tennessee</option>
                        <option value="TX" <?php if($listing_state == 'TX'){ echo 'selected'; } ?> >Texas</option>
                        <option value="UT" <?php if($listing_state == 'UT'){ echo 'selected'; } ?> >Utah</option>
                        <option value="VT" <?php if($listing_state == 'VT'){ echo 'selected'; } ?> >Vermont</option>
                        <option value="VA" <?php if($listing_state == 'VA'){ echo 'selected'; } ?> >Virginia</option>
                        <option value="WA" <?php if($listing_state == 'WA'){ echo 'selected'; } ?> >Washington</option>
                        <option value="WV" <?php if($listing_state == 'WV'){ echo 'selected'; } ?> >West Virginia</option>
                        <option value="WI" <?php if($listing_state == 'WI'){ echo 'selected'; } ?> >Wisconsin</option>
                        <option value="WY" <?php if($listing_state == 'WY'){ echo 'selected'; } ?> >Wyoming</option>
                    </select>
                </div>
                <div class="col-xs-4 col-sm-3 form-group" id="zip">
                    <input type="text" class="form-control" value="" placeholder="ZIP Code" name="listing_zip" required>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <label for="numBathrooms" class="control-label">Property Type<span class="req">*</span></label>
                <label class="radio-inline"><input type="radio" name="property_type" id="proptype1" value="Residential"> Residential</label>
                <label class="radio-inline"><input type="radio" name="property_type" id="proptype2" value="Commercial"> Commercial</label>
                <label class="radio-inline"><input type="radio" name="property_type" id="proptype3" value="Condo"> Condo</label>
                <label class="radio-inline"><input type="radio" name="property_type" id="proptype4" value="Lot/Land"> Lot/Land</label>
            </div>
        </div>
    </div>
  
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <label for="property_details" class="control-label">Property Details</label>
                <textarea class="form-control" name="property_details"></textarea>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-xs-12 form-group">&nbsp;</div>
    </div>

    <div class="row" >
        <div class="col-xs-12 form-group">
            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_KEY; ?>"></div>
        </div>
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