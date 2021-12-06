<?php

namespace Includes\Modules\Leads;

class SimpleContact extends Leads
{
    public $postType = 'Contact Submission';
    public $adminEmail = 'bryan@kerigan.com';
    public $additionalFields = [
        'full_name'     => 'Name',
        'email_address' => 'Email Address',
        'message'       => 'Message'
    ];

    public function showForm()
    {
        $form = file_get_contents(locate_template('template-parts/forms/contact-form.php'));
        $form = str_replace('{{user-agent}}', $_SERVER['HTTP_USER_AGENT'], $form);
		$form = str_replace('{{ip-address}}', $this->getIP(), $form);
        $form = str_replace('{{referrer}}', $_SERVER['HTTP_REFERER'], $form);
        
        $formSubmitted = (isset($_POST['sec']) ? ($_POST['sec'] == '' ? true : false) : false );
        ob_start();
        if($formSubmitted){
            if($this->handleLead($_POST)){
                echo '<p title="Success" class="is-success">Thank you for contacting us. Your message has been received.</p>';
            }else{
                echo '<p title="Error" class="is-danger">There was an error with your submission. Please try again.</p>';
                echo $form;
                return ob_get_clean();
            }
        }else{
            echo $form;
            return ob_get_clean();
        }
    }

    public function setupShortcode()
    {
        add_shortcode( 'contact_form', function( $atts ){
            return $this->showForm();
        } );
    }

}