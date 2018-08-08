<?php

use Includes\Modules\Team\Team;
use Includes\Modules\Leads\RequestInfo;

//DEFAULT FORM VARS
$yourname               = (isset($_GET['full_name']) ? $_GET['full_name'] : '');
$youremail              = (isset($_GET['email_address']) ? $_GET['email_address'] : '');
$phone                  = (isset($_GET['phone_number']) ? $_GET['phone_number'] : '');
$reason                 = (isset($_GET['reason_for_contact']) ? $_GET['reason_for_contact'] : '');
$mlsnumber              = (isset($_GET['mls_number']) ? $_GET['mls_number'] : '');
$emailformattedbadly    = FALSE;
$passCheck              = FALSE;
$message                = '';
$agentOptions           = '';

//IS USER LOGGED IN?
$currentUser            = get_user_meta( get_current_user_id() );
$currentUserInfo        = get_userdata( get_current_user_id() );
$yourname               = ($currentUser['first_name'][0] != '' ? $currentUser['first_name'][0] : $yourname);
$yourname               = ($currentUser['last_name'][0] != '' ? $yourname.' '.$currentUser['last_name'][0] : $yourname);
$youremail              = (isset($currentUserInfo->user_email) ? $currentUserInfo->user_email : $youremail);
$phone                  = (isset($currentUser['phone1'][0]) ? $currentUser['phone1'][0] : $phone);

$selectedAgent = (isset($_GET['selected_agent']) ? $_GET['selected_agent'] : null); //IF GET, then override.
$selectedAgent = (isset($currentUser['your_agent'][0]) && $currentUser['your_agent'][0] != '' ? $currentUser['your_agent'][0] : $selectedAgent ); //get agent from user data.
$selectedAgent = (isset($_GET['selected_agent']) && isset($_GET['reason']) && $_GET['reason'] == 'Just reaching out' ? $_GET['selected_agent'] : $selectedAgent ); //IF GET and from team, then override.


//SELECT OPTIONS
$agents     = new Team();
$agentArray = $agents->getTeam();
foreach($agentArray as $agent){
	$agentOptions .= '<option value="'.$agent['name'].'" '.($selectedAgent == $agent['slug'] ? 'selected' : '').' >'.$agent['name'].'</option>';
}

$reasonArray = array(
    'Thinking about selling' => 'Thinking about selling',
    'Thinking about buying'  => 'Thinking about buying',
    'Property inquiry'       => 'Property Inquiry',
    'Just curious'           => 'Just curious'
);

$reasonOptions = '';
foreach($reasonArray as $reasonValue => $reasonText){
	$reasonOptions .= '<option value="'.$reasonValue.'" '.($reason == $reasonValue ? 'selected' : '').' >'.$reasonText.'</option>';
}

$formID                 = (isset($_POST['formID']) ? $_POST['formID'] : '');
$securityFlag           = (isset($_POST['secu']) ? $_POST['secu'] : '');
$formSubmitted          = ($formID == 'requestinfo' && $securityFlag == '' ? TRUE : FALSE);

if( $formSubmitted ){ //FORM WAS SUBMITTED

    $leads = new RequestInfo();
    $leads->handleLead($_POST);

}

?>
<a id="request-info-form" class="pad-anchor"></a>
<form class="form leadform" enctype="multipart/form-data" method="post" action="#request-info-form" id="requestinfo">
<input type="hidden" name="formID" value="requestinfo" >
<div class="row">
    <div class="col-sm-6"> 
		<div class="form-group">
			<label>NAME<span class="req">*</span></label>
			<input name="full_name" type="text" class="form-control" value="<?php echo $yourname; ?>" required>
		</div> 
        <div class="form-group">      
            <label>EMAIL ADDRESS<span class="req">*</span></label>
            <input name="email_address" type="email" class="form-control" value="<?php echo $youremail; ?>" required>
        </div> 
        <div class="form-group"> 
            <label>PHONE*</label>
            <div class="phone-group">
                <input type="tel" name="phone_number" class="form-control" value="<?php echo $phone; ?>" placeholder="(850) ###-####" >
            </div>
        </div> 
        <div class="form-group">    			
            <label>REASON FOR CONTACT<span class="req">*</span></label>							
            <select class="form-control" name="reason_for_contact" id="reason" >
                <option value="">Select one</option>
                <?php echo $reasonOptions; ?>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group q-mls <?php echo ($mlsnumber == '' ? 'hidden-xs-up' : ''); ?>">
            <label>MLS#</label>
            <input type="text" class="form-control" value="<?php echo ($mlsnumber != '' ? $mlsnumber : ''); ?>" name="mls_number" placeholder="MLS number" />
        </div>
        
        <div class="form-group">   
            <label>YOUR AGENT<span class="req">*</span></label>
            <select class="form-control" name="selected_agent">
                <?php echo $agentOptions; ?>
            </select>
        </div>

        <div class="form-group">
            <label>MESSAGE</label>
            <textarea name="message" rows="4" class="form-control"></textarea>
        </div>
        
        <div class="form-group">
			<input type="text" name="secu" style="position: absolute; height: 1px; top: -50px; left: -50px; width: 1px; padding: 0; margin: 0; visibility: hidden;" >
            <button type="submit" class="btn btn-danger btn-md pull-md-right" >SEND</button>
        </div>
    </div>
</div> 
</form>