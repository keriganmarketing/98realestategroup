<?php

use Includes\Modules\Team\Team;
use Includes\Modules\MLS\Favorites;
use Includes\Modules\Leads\Leads;

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ninetyeight Real Estate Group
 */
$leads        = new Leads();
$favorites     = new Favorites();
$current_user = wp_get_current_user();
$userMeta     = get_user_meta($current_user->ID);
$adminemail   = 'zachchilds@gmail.com';

//SELECT OPTIONS
$agents     = new Team();
$agentArray = $agents->getTeam();
$currentAgent = get_user_meta($current_user->ID, 'your_agent', true);
$agentOptions = '';
foreach($agentArray as $agent){
    if($agent['name'] != 'Kristy Lee'){
        $agentOptions .= '<option value="'.$agent['slug'].'" '.($currentAgent == $agent['slug'] ? 'selected' : '').' >'.$agent['name'].'</option>';
    }
}

if(isset($_POST['secu']) && $_POST['secu'] == '' && isset($_POST['formID']) && $_POST['formID'] == 'agentselect'){

    if( $currentAgent != '' ){
        update_user_meta( $current_user->ID, 'your_agent', $_POST['youragent'], $currentAgent );
    } else {
        add_user_meta( $current_user->ID, 'your_agent', $_POST['youragent'] );
    }

    foreach($agentArray as $agent){
        if( $_POST['youragent'] == $agent['slug'] ){
            $adminemail = $agent['email'];
            $agentName = $agent['name'];
        }
    }

    $current_user = wp_get_current_user();
    $yourname = $current_user->data->display_name;
    $youremail = $current_user->data->user_email;

    $savedArray = [];
    foreach($favorites->getfavorites() as $favorite) {
        array_push($savedArray, $favorite->mls_account);
    }
    $postvars = array(
        'Name' => get_user_meta($current_user->data->ID,'first_name',true).' '.get_user_meta($current_user->data->ID,'last_name',true),
        'Website Username' => $yourname,
        'Email Address' => $youremail,
        'Date Registered' => $current_user->user_registered,
        'Saved Properties' => implode(',', $savedArray)
    );

    $submittedData = '<table cellpadding="0" cellspacing="0" border="0" style="width:100%" ><tbody>';
    foreach($postvars as $key => $var ){
        if(!is_array($var)){
            $submittedData .= '<tr><td>'.$key.'</td><td>'.$var.'</td></tr>';
        }else{
            $submittedData .= '<tr><td>'.$key.'</td><td '.$datastyle.'>';
            foreach($var as $k => $v){
                $submittedData .= '<span style="display:block;width:100%;">'.$v.'</span><br>';
            }
            $submittedData .= '</ul></td></tr>';
        }
    }
    $submittedData .= '</tbody></table>
    <a href="https://www.98realestategroup.com/properties/url-builder/?mlsnumbers=' . implode('+', $savedArray) . '" >View all saved properties</a>';

    //echo $adminemail;
    //$adminemail = 'bryan@kerigan.com';

    $leads->sendEmail(
        [
            'to'        => $adminemail,
            'from'      => get_bloginfo().' <noreply@98realestategroup.com>',
            'subject'   => 'You have received a new lead from the website',
            'bcc'       => 'support@kerigan.com',
            'replyto'   => $yourname . '<' . $youremail . '>',
            'headline'  => 'New Lead!',
            'introcopy' => 'A user account on the website has selected you as their agent. Their contact information is below:',
            'leadData'  => $submittedData
        ]
    );
}
get_header(); ?>

<div id="mid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">
				<div class="row">
                    <div class="col-sm-12" >
                    <?php while ( have_posts() ) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <div class="entry-content">

                                <?php
                                    the_content();
                                ?>

                                <h2>Your Agent</h2>
                                <p>Like working with one of our agents? Select them from the list to keep working with them.</p>
                                <a id="agent-select-form" class="pad-anchor"></a>
                                <form class="form" id="agentselect"  enctype="multipart/form-data" method="post" action="#agent-select-form">
                                    <input type="hidden" name="formID" value="agentselect" >
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="form-group <?php if($youragent == '' && $_POST && $_POST['formID']=='agentselect'){ echo 'has-error'; } ?>">
                                                <select class="form-control" name="youragent">
                                                  <option value="" >First Available</option>
                                                  <?php
                                                      foreach($agentarray as $agent){
                                                          if($agent['showindropdown']=='on'){
                                                          echo '<option value="'.$agent['slug'].'" ';
                                                          if( get_user_meta($current_user->ID, 'your_agent', true) == $agent['slug'] ){
                                                              echo ' selected';
                                                          }
                                                          echo ' >'.$agent['name'].'</option>';
                                                          }
                                                      }
                                                  ?>
                                                  <?php echo $agentOptions; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <input type="text" name="secu" style="position: absolute; height: 1px; top: -50px; left: -50px; width: 1px; padding: 0; margin: 0; visibility: hidden;" >
                                            <button type="submit" class="btn btn-danger btn-md" >SAVE</button>
                                        </div>
                                    </div>
                                </form>


                                <h2>Properties of Interest</h2>
                                <p>Just click the star to remove the property from your list.</p>
                                <?php echo do_shortcode('[getfavorites]'); ?>

                                <!-- <h2>Saved Searches</h2>
                                <p>Open a search that you've previously saved.</p>
                                <?php echo do_shortcode('[getsearches]'); ?> -->

                            </div><!-- .entry-content -->

                        </article><!-- #post-## -->


                    <?php endwhile; // End of the loop. ?>

                    </div>
                </div>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();
