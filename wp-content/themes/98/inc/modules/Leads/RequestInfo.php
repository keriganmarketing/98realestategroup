<?php

namespace Includes\Modules\Leads;

use Includes\Modules\Team\Team;
use Includes\Modules\MLS\FullListing;

class RequestInfo extends Leads
{

    protected $postType = 'Lead';

    public    $additionalFields = [
                'full_name'          => 'Name',
                'email_address'      => 'Email Address',
                'phone_number'       => 'Phone Number',
                'reason_for_contact' => 'Reason for Contact',
                'selected_agent'     => 'Selected Agent',
                'mls_number'         => 'MLS Number',
                'message'            => 'Message'
              ];

    public    $siteName;
    public    $errors = [];

    public    $successMessage      = 'Your request has been received. We will review your submission and get back with you soon.';
    
    public    $fromName            = '98 Real Estate Website';
    public    $fromEmail           = 'leads@mg.98realestategroup.com';

    public    $subjectLine         = 'New lead submitted on website';
    public    $emailHeadline       = 'You have a new lead from the website';
    public    $emailText           = '<p style="font-size:18px; color:black;" >A lead was received from the website. Details are below:</p>';

    public    $receiptSubjectLine  = 'Thank you for contacting 98 Real Estate Group';
    public    $receiptHeadline     = 'Your website submission has been received';
    public    $receiptText         = '<p style="font-size:18px; color:black;" >We\'ll review the information you\'ve provided and get back with you as soon as we can.</p>';

    public function overrideData($dataSubmitted)
    {
        $agent = new Team();
        $agentInfo = $agent->getSingle($dataSubmitted['selected_agent']);
        // echo '<pre style="color: #FFF;">',print_r($dataSubmitted),'</pre>';
        // echo '<pre style="color: #FFF;">',print_r($agentInfo),'</pre>';
        
        $this->adminEmail = (isset($agentInfo['email']) && $agentInfo['email'] != '' ? $agentInfo['email'] : $this->adminEmail);

        // echo $this->adminEmail;
    }

    public function additionalEmailData($leadInfo)
    {
        if($leadInfo['mls_number']!=''){
            $fullListing = new FullListing($leadInfo['mls_number']);
            $listingInfo = $fullListing->getListingInfo($leadInfo['mls_number']);

            return '<tr><td width="50%"><img src="' . $fullListing->media['photos'][0]->url . '" width="100%" ></td>
            <td><table>
                <tr><td>
                <p>' . $listingInfo->street_num.' '.$listingInfo->street_name .'<br>
                ' . $listingInfo->city . ', FL</p>
                <p><strong>$' . number_format($listingInfo->price) . '</strong></p></td></tr>
                <tr><td><a style="display: block; line-height: 20px;" href="https://98realestategroup.com/listing/' . $leadInfo['mls_number'] . '/" >View property</a></td></tr>
            </table>
            </td></tr><tr><td>&nbsp;</td></tr>';
        }
    }
}