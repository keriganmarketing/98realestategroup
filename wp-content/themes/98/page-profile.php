<?php
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


if(isset($_POST['secu']) && $_POST['secu'] == '' && isset($_POST['formID']) && $_POST['formID'] == 'agentselect'){
    
    $current_user = wp_get_current_user(); 
    if( get_user_meta($current_user->ID, 'your_agent', true) ){
        update_user_meta( $current_user->ID, 'your_agent', $_POST['youragent'] );
    } else {
        add_user_meta( $current_user->ID, 'your_agent', $_POST['youragent'] );
    }
  
    $mlsLead = new mlsLeads();
    $teamObject = new mlsTeam;
    $agentarray = $teamObject->getTeam();
  
    foreach($agentarray as $agent){
        if( $_POST['youragent'] == $agent['slug'] ){ 
            $adminemail = $agent['email'];
            $agentName = $agent['name'];
        }
    }
  
    $current_user = wp_get_current_user();
    $yourname = $current_user->data->display_name;
    $youremail = $current_user->data->user_email;

    $postvars = array(
        'Name' => $yourname,
        'Email Address' => $youremail,
        //'Phone Number' => $ph1.'-'.$ph2.'-'.$ph3,
        //'Additional Info' => htmlentities(stripslashes($_POST['additionalinfo'])),
    );

    $sendadmin = array(
        'to'		=> $adminemail,
        'from'		=> get_bloginfo().' <noreply@98realestategroup.com>',
        'subject'	=> 'You have received a new lead from the website',
        'bcc'		=> 'support@kerigan.com',
    );

    $fontstyle = 'font-family: sans-serif;';
    $headlinestyle = 'style="font-size:20px; '.$fontstyle.' color:#C41230;"';
    $copystyle = 'style="font-size:16px; '.$fontstyle.' color:#333;"';
    $labelstyle = 'style="padding:4px 8px; background:#F7F6F3; border:1px solid #E3E0D3; font-weight:bold; '.$fontstyle.' font-size:14px; color:#4D4B47; width:150px;"';
    $datastyle = 'style="padding:4px 8px; background:#F7F6F3; border:1px solid #E3E0D3; '.$fontstyle.' font-size:14px;"';

    $headline = '<h2 '.$headlinestyle.'>New Lead!</h2>';
    $adminintrocopy = '<p '.$copystyle.'>You have received a new lead from the website. Details are below:</p>';
    $dateofemail = '<p '.$copystyle.'>Date Submitted: '.date('M j, Y').' @ '.date('g:i a').'</p>';

    $submittedData = '<table cellpadding="0" cellspacing="0" border="0" style="width:100%" ><tbody>';
    foreach($postvars as $key => $var ){
        if(!is_array($var)){
            $submittedData .= '<tr><td '.$labelstyle.' >'.$key.'</td><td '.$datastyle.'>'.$var.'</td></tr>';
        }else{
            $submittedData .= '<tr><td '.$labelstyle.' >'.$key.'</td><td '.$datastyle.'>';
            foreach($var as $k => $v){
                $submittedData .= '<span style="display:block;width:100%;">'.$v.'</span><br>';
            }
            $submittedData .= '</ul></td></tr>'; 
        }
    }
    $submittedData .= '</tbody></table>';
    $submittedData .= '<p '.$copystyle.'><a class="button button-primary" target="_blank" href="http://www.98realestategroup.com/wp-admin/edit.php?s&post_status=all&post_type=search&action=-1&m=0&author_admin_filter='.$_POST['cid'].'&filter_action=Filter&paged=1&action2=-1">View Searches</a> <a class="button button-primary" target="_blank" href="http://www.98realestategroup.com/wp-admin/edit.php?s&post_status=all&post_type=favorite&action=-1&m=0&author_admin_filter='.$_POST['cid'].'&filter_action=Filter&paged=1&action2=-1">View Favorites</a></p>';

    $adminContent = $adminintrocopy.$submittedData.$dateofemail;

    $emaildata = array(
        'headline'	=> $headline, 
        'introcopy'	=> $adminContent,
    );

    $mlsLead->sendEmail($sendadmin, $emaildata);
  
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
                                                <select class="form-control" value="<?php echo $youragent; ?>" name="youragent">
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
                                
                                <h2>Saved Searches</h2>
                                <p>Open a search that you've previously saved.</p>
                                <?php echo do_shortcode('[getsearches]'); ?>
                                
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
