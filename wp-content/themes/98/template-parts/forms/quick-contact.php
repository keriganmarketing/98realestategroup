<?php

use Includes\Modules\Leads\SimpleContact;
$form = new SimpleContact();

//DEFAULT FORM VARS
$yourname               = (isset($_GET['full_name']) ? $_GET['full_name'] : '');
$youremail              = (isset($_GET['email_address']) ? $_GET['email_address'] : '');
$phone                  = (isset($_GET['phone_number']) ? $_GET['phone_number'] : '');
$emailformattedbadly    = FALSE;
$passCheck              = FALSE;
$message                = '';

$sessionAgent = (isset($_SESSION['agent_override']) ? $_SESSION['agent_override'] : null);
$overrideFields = (isset($sessionAgent) && $sessionAgent != '' ? true : false);

//IS USER LOGGED IN?
$currentUser            = get_user_meta( get_current_user_id() );
$currentUserInfo        = get_userdata( get_current_user_id() );
$yourname               = (is_array($currentUser) && $currentUser['first_name'][0] != '' ? $currentUser['first_name'][0] : $yourname);
$yourname               = (is_array($currentUser) && $currentUser['last_name'][0] != '' ? $yourname.' '.$currentUser['last_name'][0] : $yourname);
$youremail              = ($currentUserInfo && isset($currentUserInfo->user_email) ? $currentUserInfo->user_email : $youremail);
$phone                  = (is_array($currentUser) && isset($currentUser['phone1'][0]) ? $currentUser['phone1'][0] : $phone);

$selectedAgent = (is_array($currentUser) && isset($currentUser['your_agent'][0]) ? $currentUser['your_agent'][0] : null); //get agent from user data.

$formID                 = (isset($_POST['formID']) ? $_POST['formID'] : '');
$securityFlag           = (isset($_POST['secu']) ? $_POST['secu'] : '');
$formSubmitted          = ($formID == 'quickcontact' && $securityFlag == '' ? TRUE : FALSE);

//FORM WAS SUBMITTED
if( $formSubmitted ){ 
    $form->handleLead($_POST);
}

?>
<a id="quick-contact-form" class="pad-anchor"></a>
<form class="form leadform" enctype="multipart/form-data" method="post" action="#quick-contact-form" id="quickcontact">
<input type="hidden" name="formID" value="quickcontact" >
<input type="hidden" name="user_agent" value="<?php echo $form->getUserAgent(); ?>" >
<input type="hidden" name="ip_address" value="<?php echo $form->getIP(); ?>" >
<input type="hidden" name="referrer" value="<?php echo $form->getReferrer(); ?>" >
<input type="hidden" value="<?php echo $selectedAgent; ?>" name="selected_agent" >
<input type="hidden" value="Quick contact" name="reason_for_contact" >
<input type="hidden" value="" name="mls_number" >
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>NAME*</label>
                    <input name="full_name" type="text" class="form-control" value="<?php echo $yourname; ?>" required>
                </div> 
            </div>
            <div class="col-lg-6">
                <div class="form-group">      
                    <label>EMAIL ADDRESS*</label>
                    <input name="email_address" type="email" class="form-control" value="<?php echo $youremail; ?>" required>
                </div> 
            </div>
        </div>
        <div class="form-group"> 
            <label>PHONE*</label>
            <div class="phone-group">
                <input type="tel" name="phone_number" class="form-control" value="<?php echo $phone; ?>" placeholder="(###) ###-####" >
            </div>
        </div> 
    </div>
    <div class="col-sm-6">
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