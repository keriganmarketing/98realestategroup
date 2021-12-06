<?php

namespace Includes\Modules\Leads;

use KeriganSolutions\CPT\CustomPostType;

class Leads
{
    protected $postType = 'Lead';
    public    $adminEmail = 'bryan@kerigan.com';
    public    $domain = 'kerigan.com';
    public    $ccEmail = 'web@kerigan.com';
    public    $bccEmail = 'websites@kerigan.com';
    public    $additionalFields = [];
    public    $siteName;
    public    $errors = [];

    /**
     * Leads constructor.
     * configure any options here
     */
    public function __construct ()
    {
        date_default_timezone_set('America/Chicago');

        //separate multiple email addresses with a ';'
        $this->adminEmail = 'zachchilds@gmail.com';
        $this->ccEmail    = 'zachchilds@gmail.com'; //Admin email only

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

        if($this->checkSpam($dataSubmitted)){
            return null; //fail silently if spam
        }
        
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

    /*
     * Validate certain data types on the backend
     * @param array $dataSubmitted
     * @return boolean $passCheck
     */
    protected function validateSubmission($dataSubmitted)
    {

        $passCheck = true;
        if ($dataSubmitted['email_address'] == '') {
            $passCheck = false;
            $this->errors[] = 'Email cannot be left blank.';
        } elseif (!filter_var($dataSubmitted['email_address'], FILTER_VALIDATE_EMAIL) && !preg_match('/@.+\./',
            $dataSubmitted['email_address'])) {
            $passCheck = false;
            $this->errors[] = 'The provided email was improperly formatted.';
        }
        if ($dataSubmitted['full_name'] == '') {
            $passCheck = false;
            $this->errors[] = 'Name is required.';
        }
        if($dataSubmitted['g-recaptcha-response'] == ''){ 
            $passCheck = false;
            $this->errors[] = 'Please indicate that you are not a robot.';
        }elseif($this->validateCaptcha($dataSubmitted['g-recaptcha-response'])){
            $passCheck = false;
            $this->errors[] = 'Google has identified this submission as spam.';
        }

        if (function_exists('akismet_verify_key') && !empty(akismet_get_key())){
            if ($this->checkSpam($dataSubmitted)){
                $passCheck = false;
            }
        }

        return $passCheck;

    }

    protected function validateCaptcha($response)
    {      
        return false;
          
        $recaptcha = new \ReCaptcha\ReCaptcha(RECAPTCHA_SECRET);
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($response, $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess()){
            return false;
        }else{
            return true;
        }
    }

    public function getIP() 
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forwarded = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            return $client;}
        elseif (filter_var($forwarded, FILTER_VALIDATE_IP)) {
            return $forwarded;}
        else {
            return $remote;}
    } 

    public function checkSpam($dataSubmitted)
    {
        $client = new \Gothick\AkismetClient\Client(
            site_url(),           // Your website's URL (this becomes Akismet's "blog" parameter)
            "KMA Spam Checker",   // Your website or app's name (Used in the User-Agent: header when talking to Akismet)
            "1.0",                // Your website or app's software version (Used in the User-Agent: header when talking to Akismet)
            akismet_get_key()     
        );

        $result = $client->commentCheck([
            'user_ip'              => $dataSubmitted['ip_address'],
            'user_agent'           => $dataSubmitted['user_agent'],
            'referrer'             => $dataSubmitted['referrer'],
            'comment_author'       => $dataSubmitted['full_name'],
            'comment_author_email' => $dataSubmitted['email_address'],
            'comment_content'      => $dataSubmitted['message']
        ], $_SERVER);

        $spam = $result->isSpam();
        // echo '<pre>',print_r($result),'</pre>';

        return $spam; // Boolean 
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

        $this->sendEmail(
            [
                'to'        => $this->adminEmail,
                'from'      => get_bloginfo() . ' <noreply@' . $this->domain . '>',
                'subject'   => $this->postType . ' submitted on website',
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
                'from'      => get_bloginfo() . ' <noreply@' . $this->domain . '>',
                'subject'   => 'Your website submission has been received',
                'bcc'       => $this->bccEmail,
                'headline'  => 'Thank you',
                'introcopy' => 'We\'ll review the information you\'ve provided and get back with you as soon as we can.',
                'leadData'  => $tableData
            ]
        );

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
