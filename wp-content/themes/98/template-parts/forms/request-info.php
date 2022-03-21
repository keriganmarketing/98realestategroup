<?php

use Includes\Modules\Team\Team;
use Includes\Modules\Leads\RequestInfo;
$form = new RequestInfo();

//DEFAULT FORM VARS
$yourname               = (isset($_GET['full_name']) ? $_GET['full_name'] : (isset($_POST['full_name']) ? $_POST['full_name'] : ''));
$youremail              = (isset($_GET['email_address']) ? $_GET['email_address'] : (isset($_POST['email_address']) ? $_POST['email_address'] : ''));
$phone                  = (isset($_GET['phone_number']) ? $_GET['phone_number'] : (isset($_POST['phone_number']) ? $_POST['phone_number'] : ''));
$reason                 = (isset($_GET['reason_for_contact']) ? $_GET['reason_for_contact'] : (isset($_POST['reason_for_contact']) ? $_POST['reason_for_contact'] : ''));
$mlsnumber              = (isset($_GET['mls_number']) ? $_GET['mls_number'] : (isset($_POST['mls_number']) ? $_POST['mls_number'] : ''));
$message                = (isset($_POST['message']) ? $_POST['message'] : '');
$emailformattedbadly    = FALSE;
$passCheck              = FALSE;
$agentOptions           = '';

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
    $form->handleLead($_POST);
}

?>
<a id="request-info-form" class="pad-anchor"></a>
<form class="form leadform" enctype="multipart/form-data" method="post" action="#request-info-form" id="requestinfo">
    <input type="hidden" name="formID" value="requestinfo">
    <input type="hidden" name="user_agent" value="<?php echo $form->getUserAgent(); ?>">
    <input type="hidden" name="ip_address" value="<?php echo $form->getIP(); ?>">
    <input type="hidden" name="referrer" value="<?php echo $form->getReferrer(); ?>">
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>NAME<span class="req">*</span></label>
                        <input name="full_name" type="text" class="form-control" value="<?php echo $yourname; ?>"
                            required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>PHONE*</label>
                        <div class="phone-group">
                            <input type="tel" name="phone_number" class="form-control" value="<?php echo $phone; ?>"
                                placeholder="(###) ###-####">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>EMAIL ADDRESS<span class="req">*</span></label>
                <input name="email_address" type="email" class="form-control" value="<?php echo $youremail; ?>"
                    required>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>YOUR AGENT<span class="req">*</span></label>
                        <select class="form-control custom-select" name="selected_agent">
                            <option value="">First Available</option>
                            <?php echo $agentOptions; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>REASON FOR CONTACT<span class="req">*</span></label>
                        <select class="form-control custom-select" name="reason_for_contact" id="reason">
                            <option value="">Select one</option>
                            <?php echo $reasonOptions; ?>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="form-group q-mls <?php echo ($mlsnumber == '' ? 'hidden-xs-up' : ''); ?>">
                <label>MLS#</label>
                <input type="text" class="form-control" value="<?php echo ($mlsnumber != '' ? $mlsnumber : ''); ?>"
                    name="mls_number" placeholder="MLS number" />
            </div>

            <div class="form-group">
                <label>MESSAGE</label>
                <textarea style="height:113px;" name="message" rows="4"
                    class="form-control"><?php echo $message; ?></textarea>
            </div>

            <input type="text" name="secu"
                style="position: absolute; height: 1px; top: -50px; left: -50px; width: 1px; padding: 0; margin: 0; visibility: hidden;">
            <button style="margin-top: 1rem;" type="submit" class="btn btn-danger btn-md pull-xs-right">SEND</button>
        </div>
    </div>
</form>