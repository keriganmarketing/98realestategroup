<?php

namespace Includes\Modules\Leads;

use Includes\Modules\Team\Team;

class HomeValuation extends Leads
{

    public $postType = 'Home Valuation';

    public $additionalFields = [
        'full_name'          => 'Name',
        'email_address'      => 'Email Address',
        'phone_number'       => 'Phone Number',
        'selected_agent'     => 'Selected Agent',
        'property_address'   => 'Property Address',
        'property_type'      => 'Property Type',
        'property_details'   => 'Property Details'
    ];

    public  $requiredFields = [
        'email_address',
        'phone_number',
        'full_name',
        'property_address',
        'property_type',
    ];

    public    $successMessage      = 'Your request has been received. We will review your submission and get back with you soon.';
    
    public    $fromName            = '98 Real Estate Website';
    public    $fromEmail           = 'leads@mg.98realestategroup.com';

    public    $subjectLine         = 'New home valuation lead submitted on website';
    public    $emailHeadline       = 'You have a home valuation lead from the website';
    public    $emailText           = '<p style="font-size:18px; color:black;" >A home valuation lead was received from the website. Details are below:</p>';

    public    $receiptSubjectLine  = 'Thank you for contacting 98 Real Estate Group';
    public    $receiptHeadline     = 'Your home valuation submission has been received';
    public    $receiptText         = '<p style="font-size:18px; color:black;" >We\'ll review the information you\'ve provided and get back with you as soon as we can.</p>';

    public function overrideData($dataSubmitted)
    {
        $dataSubmitted['property_address'] = $this->toFullAddress(
            $dataSubmitted['listing_address'], $dataSubmitted['listing_address_2'],
            $dataSubmitted['listing_city'], $dataSubmitted['listing_state'], $dataSubmitted['listing_zip']
        );

        $dataSubmitted['message'] = $dataSubmitted['property_details'];

        $agent = new Team();
        $agentInfo = $agent->getSingle($dataSubmitted['selected_agent']);
        // echo '<pre>',print_r($dataSubmitted),'</pre>';
        // echo '<pre>',print_r($agentInfo),'</pre>';
        
        $this->adminEmail = (isset($agentInfo['email']) && $agentInfo['email'] != '' ? $agentInfo['email'] : $this->adminEmail);
        // $this->adminEmail = 'bryan@kerigan.com';
        // echo $this->adminEmail;

        return $dataSubmitted;
    }
}