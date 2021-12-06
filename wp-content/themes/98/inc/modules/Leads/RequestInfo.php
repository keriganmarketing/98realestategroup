<?php

namespace Includes\Modules\Leads;

use Includes\Modules\Team\Team;
use Includes\Modules\MLS\FullListing;

class RequestInfo extends Leads
{

    public $additionalFields = [
        'full_name'          => 'Name',
        'email_address'      => 'Email Address',
        'phone_number'       => 'Phone Number',
        'reason_for_contact' => 'Reason for Contact',
        'selected_agent'     => 'Selected Agent',
        'mls_number'         => 'MLS Number',
        'message'            => 'Message'
    ];

    public function handleLead ($dataSubmitted = [])
    {
        $dataSubmitted['full_name'] = (isset($dataSubmitted['full_name']) ? $dataSubmitted['full_name'] :
            (isset($dataSubmitted['first_name']) ? $dataSubmitted['first_name'] . ' ' . $dataSubmitted['last_name'] : '')
        );

        if($this->checkSpam($dataSubmitted)){
            return null; //fail silently if spam
        }

        $agent = new Team();
        $agentInfo = $agent->getSingle($dataSubmitted['selected_agent']);
        // echo '<pre style="color: #FFF;">',print_r($dataSubmitted),'</pre>';
        // echo '<pre style="color: #FFF;">',print_r($agentInfo),'</pre>';
        
        // parent::set('adminEmail', (isset($agentInfo['email']) && $agentInfo['email'] != '' ? $agentInfo['email'] : $this->adminEmail));
        $this->adminEmail = (isset($agentInfo['email']) && $agentInfo['email'] != '' ? $agentInfo['email'] : $this->adminEmail);
        
        if($this->validateSubmission($dataSubmitted)){
            echo '<div class="alert alert-success" role="alert">
            <strong>Your request has been received. We will review your submission and get back with you soon.</strong>
            </div>';
        }else{
            echo '<div class="alert alert-danger" role="alert">
            <strong>Errors were found. Please correct the indicated fields below.</strong>';
            if(count($this->errors) > 0){
                echo '<ul>';
                foreach($this->errors as $error){
                    echo '<li>'.$error.'</li>';
                }
                echo '</ul>';
            }
            echo '</div>';
            return;
        }

        $this->addToDashboard($dataSubmitted);
        $this->sendNotifications($dataSubmitted);

    }

    protected function sendNotifications ($leadInfo)
    {
        $emailAddress = (isset($leadInfo['email_address']) ? $leadInfo['email_address'] : null);
        $fullName     = (isset($leadInfo['full_name']) ? $leadInfo['full_name'] : null);

        $tableData = '';
        foreach ($this->additionalFields as $key => $var) {
            if($leadInfo[$key]!='') {
                $tableData .= '<tr><td class="label"><strong>' . $var . '</strong></td><td>' . htmlentities(stripslashes($leadInfo[$key])) . '</td>';
            }
        }

        if($leadInfo['mls_number']!=''){

            $fullListing = new FullListing($leadInfo['mls_number']);
            $listingInfo = $fullListing->getListingInfo($leadInfo['mls_number']);

            $tableData .= '<tr><td width="50%"><img src="' . $fullListing->media['photos'][0]->url . '" width="100%" ></td>
            <td><table>
                <tr><td>
                <p>' . $listingInfo->street_num.' '.$listingInfo->street_name .'<br>
                ' . $listingInfo->city . ', FL</p>
                <p><strong>$' . number_format($listingInfo->price) . '</strong></p></td></tr>
                <tr><td><a style="display: block; line-height: 20px;" href="https://98realestategroup.com/listing/' . $leadInfo['mls_number'] . '/" >View property</a></td></tr>
            </table>
            </td></tr><tr><td>&nbsp;</td></tr>';
        }

        $this->sendEmail(
            [
                'to'        => $this->adminEmail,
                'from'      => get_bloginfo().' <noreply@98realestategroup.com>',
                'subject'   => 'You have received a new lead from the website',
                'cc'        => $this->ccEmail,
                'bcc'       => $this->bccEmail,
                'replyto'   => $fullName . '<' . $emailAddress . '>',
                'headline'  => 'You have a new ' . strtolower($this->postType),
                'introcopy' => 'A ' . strtolower($this->postType) . ' was received from the website. Details are below:',
                'leadData'  => $tableData
            ]
        );

        $this->sendEmail(
            [
                'to'        => $fullName . '<' . $emailAddress . '>',
                'from'      => get_bloginfo().' <noreply@98realestategroup.com>',
                'subject'   => 'Your website submission has been received',
                'bcc'       => $this->bccEmail,
                'headline'  => 'Thank you',
                'introcopy' => 'We\'ll review the information you\'ve provided and get back with you as soon as we can.',
                'leadData'  => $tableData
            ]
        );

    }

}