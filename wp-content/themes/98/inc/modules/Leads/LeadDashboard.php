<?php

namespace Includes\Modules\Leads;

use KeriganSolutions\CPT\CustomPostType;
use Includes\Modules\Team\Team;
use Includes\Modules\Leads\Leads;

class LeadDashboard
{
    public function __construct(){

    }

    public function createPage()
    {
        add_action('admin_menu', [$this, 'add_menu_item']);
        //add_action('admin_init', [$this, 'page_fields_init']);
    }

    /**
     * Add options page menu item
     */
    public function add_menu_item()
    {
        // This page will be under "Settings"
        add_menu_page(
            'Lead Dashboard',
            'Lead Dashboard',
            'edit_published_posts',
            'lead-dashboard',
            [$this, 'create_admin_page'],
            '', 
            0
        );
    }

    /**
     * Page callback
     */
    public function create_admin_page()
    {
        ?>
		<div class="wrap">
			<h1>Lead Dashboard</h1>
        <?php

$current_user = wp_get_current_user(); 
    
$args = array(
    'blog_id'      => $GLOBALS['blog_id'],
    'role__in'     => array(),
    'role__not_in' => array(),
    'meta_key'     => '',
    'meta_value'   => '',
    'meta_compare' => '',
    'meta_query'   => array(),
    'date_query'   => array(),        
    'include'      => array(),
    'exclude'      => array(),
    'orderby'      => 'user_registered',
    'order'        => 'DESC',
    'offset'       => '',
    'search'       => '',
    'number'       => '',   
    'count_total'  => false,
    'fields'       => 'all',
    'who'          => ''
); 
$clientlist = get_users( $args );

$teamObject = new Team;
$agentarray = $teamObject->getTeam();

add_thickbox();
$thickbox = '';

echo '<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th>Name</th>
<th>Email Address</th>
<th>Assigned Agent</th>
<th>Actions</th>
<th width="170">Date Registered</th>
</tr>
</thead>';

foreach($clientlist as $client){ 
  
    $myagent = get_user_meta($client->ID, 'your_agent', true);
    $leadowner = str_replace(' ', '-', strtolower($current_user->display_name));
          
    $favlist = $this->getFavoritesByUser($client->ID);  
    
    $numfavs = count( $favlist );

    $allAgents = get_user_meta($client->ID, 'your_agent', false);

    if(count($allAgents) > 0) {
        foreach($allAgents as $agent){
            if($agent == ''){
                delete_user_meta( $client->ID, 'your_agent', $agent );
            }
        }
    }
    
    if($myagent != ''){
        if($leadowner == 'kma' || $leadowner == 'zach-childs' ) { 
            $admininfo = ' ( assigned to '.ucwords(str_replace('-',' ',$myagent)).' )'; } else { $admininfo = ''; 
        }
    }else{
        if($leadowner == 'kma' || $leadowner == 'zach-childs') { 
            $admininfo = ' ( no agent selected )'; 
            $admininfo .= ' <a href="#TB_inline?width=300&height=200&inlineId=assignagent'.$client->ID.'" role="button" data-toggle="modal" class="button button-info thickbox" >Assign Agent</a>';
        } else { $admininfo = ''; }
    }
    $name = $client->display_name.$admininfo;

    $leadMeta = get_user_meta($client->data->ID);
    
    //echo '<pre>',print_r($client),'</pre>';
    
    //show info
    echo '
    <tr>
    <td><strong>'.get_user_meta($client->data->ID,'first_name',true).' '.get_user_meta($client->data->ID,'last_name',true).'</strong></td>
    <td><a href="'.$client->user_email.'" >'.$client->user_email.'</a></td>
    <td>'.$admininfo.'</td>
    <td><a class="button button-primary" href="/wp-admin/edit.php?s&post_status=all&post_type=favorite&action=-1&m=0&author_admin_filter='.$client->ID.'&filter_action=Filter&paged=1&action2=-1" >View Favorites ('.$numfavs.')</a></td>
    <td>'.$client->user_registered.'</td>
    </tr>';
          
    $thickbox .= '<div id="assignagent'.$client->ID.'" class="modal hide fade" style="display:none;">

            <div style="margin:20px;">
                <h3>Assign Agent to this Customer</h3>
                <p>Change this to associate the lead with an agent. Once selected, an email notification will be sent to the agent. Selecting "First Available" will not make any changes.</p>
                <form class="form" id="agentselect"  enctype="multipart/form-data" method="post" action="#agent-select-form">
                    <input type="hidden" name="formID" value="agentselect" >
                    <input type="hidden" name="cid" value="'.$client->ID.'">
                    <input type="hidden" name="cname" value="'.$client->display_name.'">
                    <input type="hidden" name="cemail" value="'.$client->user_email.'">
                    <label>Select Agent: </label>
                    <select class="form-control" name="youragent">
                        <option value="" >First Available</option>';
                        foreach($agentarray as $agent){
                            $thickbox .= '<option value="'.$agent['slug'].'" >'.$agent['name'].'</option>';
                        }
                        $thickbox .= '</select>

                    <input type="text" name="secu" style="position: absolute; height: 1px; top: -50px; left: -50px; width: 1px; padding: 0; margin: 0; visibility: hidden;" >
                    <button type="submit" class="button button-primary" >SAVE</button>

                </form>
            </div>
        </div>';
    
}

echo '</table>';

echo $thickbox;




if(isset($_POST['secu']) && $_POST['secu'] == '' && isset($_POST['formID']) && $_POST['formID'] == 'agentselect'){

    $leads = new Leads();

    $currentAgent = get_user_meta( $_POST['cid'], 'your_agent', true);
    if( $currentAgent != '' ){
        update_user_meta( $current_user->ID, 'your_agent', $_POST['youragent'], $currentAgent );
    } else {
        add_user_meta( $current_user->ID, 'your_agent', $_POST['youragent'] );
    }
    
    foreach($agentarray as $agent){
        if( $_POST['youragent'] == $agent['slug'] ){ 
            $adminemail = $agent['email'];
            $agentName = $agent['name'];
        }
    }
        
    $current_user = get_userdata($_POST['cid']);

    $yourname = $current_user->data->display_name;
    $youremail = $current_user->data->user_email;

    $favorites = $this->getFavoritesByUser($_POST['cid']);
    $favlist = implode(',',$favorites);  

    $postvars = array(
        'Name' => get_user_meta($_POST['cid'],'first_name',true).' '.get_user_meta($_POST['cid'],'last_name',true),
        'Website Username' => $yourname,
        'Email Address' => $youremail,
        'Favorite Properties' => '',
        'Date Registered' => $current_user->user_registered
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
    $submittedData .= '</tbody></table>';

    //$adminemail = 'bryan@kerigan.com';

    $leads->sendEmail(
        [
            'to'        => $adminemail,
            'from'      => get_bloginfo().' <noreply@98realestategroup.com>',
            'subject'   => 'You have been assigned a new lead from the website',
            'bcc'       => 'support@kerigan.com',
            'replyto'   => $yourname . '<' . $youremail . '>',
            'headline'  => 'New Lead!',
            'introcopy' => 'You have been assigned a new lead using the website lead dashboard. Details are below:',
            'leadData'  => $submittedData
        ]
    );
  
    echo '<script>parent.window.location.reload();</script>';
  
}

?>

		</div>
		<?php
    }

    public function getFavoritesByUser($userID){
        $request = [
            'posts_per_page'  => -1, 
            'orderby'   	  => 'post_date',
            'post_type'       => 'favorite',
            'post_status'     => 'publish',	
            'author'          => $userID
        ];

        $favs = get_posts( $request );    
        $favList = [];
    
        foreach ( $favs as $fav ){            
            $favList[] = $fav->favorite_info_mlsnum;
        }

        //echo '<pre>',print_r($favList),'</pre>';

        return $favList;

    }

}