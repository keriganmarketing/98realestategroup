<?php

namespace Includes\Modules\Leads;

use KeriganSolutions\CPT\CustomPostType;

class Leads
{
    protected $postType = 'Lead';
    public    $adminEmail = 'zachchilds@gmail.com';
    public    $domain = 'mg.98realestategroup.com';
    public    $ccEmail = 'web@kerigan.com';
    public    $bccEmail = 'websites@kerigan.com';
    public    $additionalFields = [];
    public    $siteName;
    public    $errors = [];
    public    $notGood = false;

    public    $successMessage      = 'Your request has been received. We will review your submission and get back with you soon.';
    
    public    $fromName            = '98 Real Estate Website';
    public    $fromEmail           = 'leads@mg.98realestategroup.com';

    public    $subjectLine         = 'New lead submitted on website';
    public    $emailHeadline       = 'You have a new lead from the website';
    public    $emailText           = '<p style="font-size:18px; color:black;" >A lead was received from the website. Details are below:</p>';

    public    $receiptSubjectLine  = 'Thank you for contacting 98 Real Estate Group';
    public    $receiptHeadline     = 'Your website submission has been received';
    public    $receiptText         = '<p style="font-size:18px; color:black;" >We\'ll review the information you\'ve provided and get back with you as soon as we can.</p>';

    public $requiredFields = [
        'email_address',
        'full_name', // dynamically created using first and last
    ];

    // blck anything at these domains
    public  $blockedDomains = [
        'partcafe.com',
        'e-correo.co',
        'officemail.in.net',
        'quelbroker.com',
        '.bekkr.com',
        '.blastzane.com',
        'prior.nedmr.com',
        'verywd.com',
        'spambog.com',
        'knol-power.nl',
        '1secmail.com',
        'meta1.in.net',
        'savedaday.com',
        '.sudeu.com',
        'vipitv.com',
        'kogobee.com',
        '.ceako.com',
        '.papte.com',
        '.ceako.com',
        'x24hr.com',
        'discard.email',
        'swegu.com',
        'mailmanila.com',
        'smilietoys.com',
        '.dynainbox.com',
        'anonmails.de',
        'econgate.com',
        'a-troninc.com',
        '.thailandmovers.com',
        '.roofvent.',
        '.bangkokremovals.',
        'vipitv.com',
        'wing.onstir.com',
        '.officemail.in.net',
        '.officemail.fun',
        'chiefdan.com',
        'nestmoon.com',
        '.meta1.in.net',
        'edusath.com',
        'dasemana.com',
        '.blastzane.com',
        'dcctb.com',
        'thetrizzy.com',
        'knol-power.nl',
        'spambog.com',
        'woeishyang.com',
        'wwjmp.com',
        'mailmenot.io',
        'vddaz.com',
        '.sudeu.com',
        '.nedmr.com',
        '.papte.co',
        '.verywd.com',
        'esiix.com',
        'rexsr.com',
        'bobtamboli.com',
        'tony-ng.com',
        'transatusa.com',
        'ctcables.com',
        'snterra.com',
        'duxarea.com',
        'ann-cole.com',
        'findabridge.com',
        'coylevarland.com',
        'skincareproductoffers.com',
        'skankville.com',
        'callsbo.com',
        'incisives.com',
        'ecorreos.space',
        '5hike.com',
        'xixeo.com'
    ];

    // well-known domains
    public  $blacklist = [
        'yourdomainaguru.cristina1@gmail.com',
        'santos.denehy@yahoo.com',
        'rambomordo@hotmail.com',
        'jordanjaceseo@gmail.com',
        'ericka.joshua@gmail.com',
        'raushanahmullarkey805@aol.com',
        'orimenas1970@yahoo.com',
        'springertheresa473@yahoo.com',
        'amaratucholski19@yahoo.com',
        'assayamberbn3594@yahoo.com',
        'lavetatakenakahf@yahoo.com',
        'veliawestover48@yahoo.com',
        'katelandcoren91@yahoo.com',
        'classiebourneka@yahoo.com',
        'lillianathai833@yahoo.com',
        'alaricmitchencw@yahoo.com'
    ];

    /**
     * Leads constructor.
     * configure any options here
     */
    public function __construct ()
    {
        //separate multiple email addresses with a ';'
        // $this->adminEmail = 'zachchilds@gmail.com';
        // $this->ccEmail    = 'zachchilds@gmail.com'; //Admin email only
    }

    protected function set($var, $value)
    {
        $this->$var = $value;
    }

    protected function get($var)
    {
        return $this->$var;
    }

    protected function uglify($var){
        return str_replace(' ', '_', strtolower($var));
    }

    /**
     * Creates custom post type and backend view
     * @instructions run once from functions.php
     */
    public function setupAdmin ()
    {
        $this->createPostType();
        $this->createAdminColumns();
    }

    /**
     * Handle data submitted by lead form
     * @param array $dataSubmitted
     * @instructions pass $_POST to $dataSubmitted from template file
     */
    public function handleLead ($dataSubmitted = [])
    {
        $fullName = (isset($dataSubmitted['full_name']) ? $dataSubmitted['full_name'] : null);
        $dataSubmitted['full_name'] = (isset($dataSubmitted['first_name']) && isset($dataSubmitted['last_name']) ? $dataSubmitted['first_name'] . ' ' . $dataSubmitted['last_name'] : $fullName);

        $dataSubmitted = $this->overrideData($dataSubmitted);
        $this->validateSubmission($dataSubmitted);

        if($this->notGood){
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

            return false; 
        }else{
            echo '<div class="alert alert-success" role="alert">
            <strong>' . $this->successMessage . '</strong>
            </div>';
        }

        // silently discard bot submissions
        if(isset($dataSubmitted['terms']) && $dataSubmitted['terms']) {
            return true;
        }

        $this->addToDashboard($dataSubmitted);
        $this->sendNotifications($dataSubmitted);

        return true;
    }

    /**
     * Override email data based on form submitted
     */
    public function overrideData($dataSubmitted)
    {
        return $dataSubmitted;
    }

    /*
     * Validate certain data types on the backend
     * @param array $dataSubmitted
     * @return boolean $passCheck
     */
    protected function validateSubmission($dataSubmitted)
    {        
        // loop through other required fields to make sure they are not blank
        foreach($this->requiredFields as $field){
            if ( $dataSubmitted[$field] === null || $dataSubmitted[$field] === '') {
                $this->notGood = true;
                $this->errors[] = 'The ' . $this->additionalFields[$field] . ' field is required.';
            }
    
            // check email formatting
            if($field == 'email_address'){
                if ( ! filter_var($dataSubmitted['email_address'], FILTER_VALIDATE_EMAIL)) {
                    $this->notGood = true;
                    $this->errors[] = 'The email address you entered is invalid.';
                }
            }
        }

        if(in_array($dataSubmitted['email_address'], $this->blacklist)) {
            $this->notGood = true;
            $this->errors[] = 'The email address you entered is blacklisted.';
        }

        foreach($this->blockedDomains as $string) {
            if(strpos($dataSubmitted['email_address'], $string) !== false) 
            {
                
                $this->notGood = true;
                $this->errors[] = 'The email provider you entered is blacklisted.';
            }
        }

        if ($this->checkSpam($dataSubmitted)){
            $this->notGood = true;
            $this->errors[] = 'Your message has been identified as spam.';
        }
    }

    public function getIP()
    {
        $Ip = '0.0.0.0';
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != '')
        $Ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '')
        $Ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '')
        $Ip = $_SERVER['REMOTE_ADDR'];
        if (($CommaPos = strpos($Ip, ',')) > 0)
        $Ip = substr($Ip, 0, ($CommaPos - 1));

        return $Ip;
    }

    public function getReferrer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }

    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
    }

    public function checkSpam($data)
    {
        // not spam if akismet isn't active
        if(!function_exists('akismet_http_post')) {
            return false;
        }
    
        global $akismet_api_host, $akismet_api_port;
    
        // data package to be delivered to Akismet
        $commentData = [
            'comment_author_email'  => $data['email_address'], //required
            'blog'                  => site_url(),
            'blog_lang'             => 'en_US',
            'blog_charset'          => 'UTF-8',
            'is_test'               => TRUE,
        ];

        if(isset($data['ip_address'])){
            $commentData['user_ip'] = $data['ip_address'];
        }
    
        if(isset($data['user_agent'])){
            $commentData['user_agent'] = $data['user_agent'];
        }
    
        if(isset($data['referrer'])){
            $commentData['referrer'] = $data['referrer'];
        }
    
        if(isset($data['full_name'])){
            $commentData['comment_author'] = $data['full_name'];
        }
    
        if(isset($data['message'])){
            $commentData['comment_content'] = $data['message'];
        }

        // construct the query string
        $query_string = http_build_query( $commentData );
        // post it to Akismet
        $response = akismet_http_post( $query_string, $akismet_api_host, '/1.1/comment-check', $akismet_api_port );

        // the result is the second item in the array, boolean
        return $response[1] == 'true' ? true : false;
    }

    /**
     * adds a lead (post) to WP admin dashboard (database)
     * @param array $leadInfo
     */
    protected function addToDashboard ($leadInfo)
    {

        $fieldArray = [];
        foreach($this->additionalFields as $name => $label){
            $fieldArray['lead_info_' . $name] = (isset($leadInfo[$name]) ? $leadInfo[$name] :  null);
        }

        wp_insert_post(
            [
                'post_content'   => '',
                'post_status'    => 'publish',
                'post_type'      => $this->uglify($this->postType),
                'post_title'     => $leadInfo['full_name'],
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
                'meta_input'     => $fieldArray
            ],
            true
        );
    }

    /**
     * Returns a properly formatted address
     * @param  $street
     * @param  $street2
     * @param  $city
     * @param  $state
     * @param  $zip
     *
     * @return string
     */
    protected function toFullAddress ($street, $street2, $city, $state, $zip)
    {
        return $street . ' ' . $street2 . ' ' . $city . ', ' . $state . '  ' . $zip;
    }

    public function getLeads($args = []){
        $request = [
            'posts_per_page' => - 1,
            'offset'         => 0,
            'post_type'      => $this->uglify($this->postType),
            'post_status'    => 'publish',
        ];

        $args = array_merge( $request, $args );
        $results = get_posts( $args );

        $resultArray = [];
        foreach ( $results as $item ){
            $meta = get_post_meta($item->ID);
            $resultArray[] = [
                'object' => $item,
                'meta'   => $meta
            ];
        }

        return $resultArray;
    }

    /*
     * Sends notification email(s)
     * @param array $leadInfo
     */
    protected function sendNotifications ($leadInfo)
    {
        $emailAddress = (isset($leadInfo['email_address']) ? $leadInfo['email_address'] : null);
        $fullName     = (isset($leadInfo['full_name']) ? $leadInfo['full_name'] : null);

        $tableData = '';
        foreach ($this->additionalFields as $key => $var) {
            if(isset($leadInfo[$key])) {
                $tableData .= '<tr><td class="label"><strong>' . $var . '</strong></td><td>' . $leadInfo[$key] . '</td>';
            }
        }

        $tableData .= $this->additionalEmailData($leadInfo);

        $this->sendEmail(
            [
                'to'        => $this->adminEmail,
                'from'      => $this->fromName . ' <'. $this->fromEmail . '>',
                'subject'   => $this->subjectLine,
                'cc'        => $this->ccEmail,
                'bcc'       => $this->bccEmail,
                'replyto'   => $fullName . '<' . $emailAddress . '>',
                'headline'  => $this->emailHeadline,
                'introcopy' => $this->emailText,
                'leadData'  => $tableData
            ]
        );

        $this->sendEmail(
            [
                'to'        => $fullName . '<' . $emailAddress . '>',
                'from'      => $this->fromName . ' <'. $this->fromEmail . '>',
                'subject'   => $this->receiptSubjectLine,
                'bcc'       => $this->bccEmail,
                'headline'  => $this->receiptHeadline,
                'introcopy' => $this->receiptText,
                'leadData'  => $tableData
            ]
        );

    }

    
    public function additionalEmailData($leadInfo)
    {
        return '';
    }

    /**
     * Creates a custom post type and meta boxes (now dynamic)
     */
    protected function createPostType ()
    {

        $leads = new CustomPostType(
            $this->postType,
            [
                'supports'           => ['title'],
                'menu_icon'          => 'dashicons-star-empty',
                'has_archive'        => false,
                'menu_position'      => null,
                'public'             => false,
                'publicly_queryable' => false,
            ]
        );

        $fieldArray = [];
        foreach($this->additionalFields as $name => $label){
            $fieldArray[$label] = 'locked';
        }

        $leads->addMetaBox(
            'Lead Info', $fieldArray
        );
    }

    /*
     * Creates columns and data in admin panel
     */
    protected function createAdminColumns ()
    {

        //Adds Column labels. Can be enabled/disabled using screen options.
        add_filter('manage_' . $this->uglify($this->postType) . '_posts_columns', function () {

            $additionalLabels = [];
            foreach($this->additionalFields as $name => $label) {
                if($name != 'first_name' && $name != 'last_name' && $name != 'full_name') {
                    $additionalLabels[$name] = $label;
                }
            }

            $defaults = array_merge(
                [
                    'title'         => 'Name',
                    'email_address' => 'Email',
                    'phone_number'  => 'Phone Number',
                ], $additionalLabels
            );

            $defaults['date'] = 'Date Posted'; //always last

            return $defaults;
        }, 0);

        //Assigns values to columns
        add_action('manage_' . $this->uglify($this->postType) . '_posts_custom_column', function ($column_name, $post_ID) {
            if($column_name != 'title' && $column_name != 'date'){
                switch ($column_name) {
                    case 'email_address':
                        $email_address = get_post_meta($post_ID, 'lead_info_email_address', true);
                        echo(isset($email_address) ? '<a href="mailto:' . $email_address . '" >' . $email_address . '</a>' : null);
                        break;
                    case 'phone_number':
                        $phone_number = get_post_meta($post_ID, 'lead_info_phone_number', true);
                        echo(isset($phone_number) ? '<a href="tel:' . $phone_number . '" >' . $phone_number . '</a>' : null);
                        break;
                    default:
                        echo get_post_meta($post_ID, 'lead_info_' . $column_name, true);
                }
            }
        }, 0, 2);
    }

    /*
     * grabs blank template file and fills with content
     * @return string
     */
    protected function createEmailTemplate ($emailData)
    {
        $eol           = "\r\n";
        $emailTemplate = file_get_contents(wp_normalize_path(get_template_directory() . '/inc/modules/Leads/emailtemplate.php'));
        $emailTemplate = str_replace('{headline}', $eol . $emailData['headline'] . $eol, $emailTemplate);
        $emailTemplate = str_replace('{introcopy}', $eol . $emailData['introcopy'] . $eol, $emailTemplate);
        $emailTemplate = str_replace('{data}', $eol . $emailData['leadData'] . $eol, $emailTemplate);
        $emailTemplate = str_replace('{datetime}', date('M j, Y') . ' @ ' . date('g:i a'), $emailTemplate);
        $emailTemplate = str_replace('{website}', 'www.' . $this->domain, $emailTemplate);
        $emailTemplate = str_replace('{url}', 'https://' . $this->domain, $emailTemplate);
        $emailTemplate = str_replace('{copyright}', date('Y') . ' ' . get_bloginfo(), $emailTemplate);
        return $emailTemplate;
    }

    /*
     * actually send an email
     * TODO: Add handling for attachments
     */
    public function sendEmail ( $emailData = [] ) {
        $eol           = "\r\n";
        $emailTemplate = $this->createEmailTemplate($emailData);
        $headers       = 'From: ' . $emailData['from'] . $eol;
        $headers       .= (isset($emailData['cc']) ? 'Cc: ' . $emailData['cc'] . $eol : '');
        $headers       .= (isset($emailData['bcc']) ? 'Bcc: ' . $emailData['bcc'] . $eol : '');
        $headers       .= (isset($emailData['replyto']) ? 'Reply-To: ' . $emailData['replyto'] . $eol : '');
        $headers       .= 'MIME-Version: 1.0' . $eol;
        $headers       .= 'Content-type: text/html; charset=utf-8' . $eol;

        wp_mail($emailData['to'], $emailData['subject'], $emailTemplate, $headers);
    }
}