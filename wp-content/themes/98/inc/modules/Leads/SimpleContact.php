<?php

namespace Includes\Modules\Leads;

use Includes\Modules\Team\Team;

class SimpleContact extends Leads
{
    public $postType               = 'Contact Submission';

    public $additionalFields       = [
        'full_name'     => 'Name',
        'phone_number'  => 'Phone Number',
        'email_address' => 'Email Address',
        'message'       => 'Message'
    ];

    public $requiredFields         = [
        'email_address',
        'phone_number',
        'full_name', // dynamically created using first and last
        'message'
    ];

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
        // $this->adminEmail = 'bryan@kerigan.com';
        // echo $this->adminEmail;

        return $dataSubmitted;
    }
}