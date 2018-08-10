<?php
/**
 * Seriously Creative functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ninetyeight Real Estate Group
 */

use Includes\Modules\Team\Team;
use Includes\Modules\Leads\Leads;
use Includes\Modules\Helpers\CleanWP;
use Includes\Modules\MLS\FeaturedProperties;
use Includes\Modules\MLS\Favorites;

require('vendor/autoload.php');

new CleanWP();

$team = new Team();
$team->setupAdmin();

new FeaturedProperties;

$favorites = new Favorites;
$favorites->setupAdmin();
$favorites->addRoutes();

if ( ! function_exists( 'ninetyeight_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ninetyeight_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Seriously Creative, use a find and replace
	 * to change 'ninetyeight' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ninetyeight', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'ninetyeight' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ninetyeight_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'ninetyeight_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ninetyeight_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ninetyeight_content_width', 640 );
}
add_action( 'after_setup_theme', 'ninetyeight_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ninetyeight_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'ninetyeight' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'ninetyeight' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'ninetyeight' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'ninetyeight' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'ninetyeight' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'ninetyeight' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 4', 'ninetyeight' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here.', 'ninetyeight' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'ninetyeight_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ninetyeight_scripts() {
    wp_enqueue_style( 'ninetyeight-style', get_stylesheet_uri() );
    wp_enqueue_script('ninetyeight-script', get_template_directory_uri().'/app.js', [], '', true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ninetyeight_scripts' );

//DISABLE WP CORE CRAP
remove_action('wp_head', 'rsd_link'); // Removes the Really Simple Discovery link
remove_action('wp_head', 'wlwmanifest_link'); // Removes the Windows Live Writer link
remove_action('wp_head', 'wp_generator'); // Removes the WordPress version
remove_action('wp_head', 'start_post_rel_link'); // Removes the random post link
remove_action('wp_head', 'index_rel_link'); // Removes the index page link
remove_action('wp_head', 'adjacent_posts_rel_link'); // Removes the next and previous post links
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'feed_links', 2); // remove rss feed links *** RSS ***
remove_action('wp_head', 'feed_links_extra', 3); // removes all rss feed links
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );

function disable_wp_emojicons() {

  // all actions related to emojis
  //remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  //remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  //add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
//******************************************************************************************
//Allow subscribers to delete their own posts
function add_subscriber_delete_cap() {
    $role = get_role( 'subscriber' );
    $role->add_cap( 'delete_posts' );
    $role->add_cap( 'delete_published_posts' );
}
add_action( 'admin_init', 'add_subscriber_delete_cap');
// Add CSS to hide everything in the admin while the JS above does it's trick
add_action('admin_head', 'hide_admin_via_css');
function hide_admin_via_css() {
    if (!current_user_can( 'publish_posts' )) {
        echo '<style>body * {visibility:hidden !important;} body:before {content:"One moment while you are redirected...";}
';
    }
}
// Add Javascript to redirect anyone but administrators out of the admin area after 10 seconds
function my_enqueue( $hook ) {
    if (!current_user_can( 'publish_posts' )) {
        wp_enqueue_script( 'my_custom_script', '/wp-content/themes/98/js/block-admin.js' );
    }
}
add_action('admin_enqueue_scripts', 'my_enqueue');
//End of allowing subscribers to add their own posts
//********************************************************************************************

function wp_delete_post_link($id, $link = 'Delete This', $before = '', $after = '') {
    global $post;
    $post->ID = $id;
    $message = esc_attr("Are you sure you want to delete ".get_the_title($post->ID)." ?");
    $delLink = get_delete_post_link($post->ID);
    $htmllink = "<a href='" . $delLink . "' onclick = \"if ( confirm('".$message."' ) ) { execute(); return true; } return false;\"/>".$link."</a>";
    return $before . $htmllink . $after;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


function wp_bs_pagination($pages = '', $range = 4){  
     $showitems = ($range * 2) + 1;  
     global $paged;
     if(empty($paged)) $paged = 1;
     if($pages == ''){
         global $wp_query; 
		 $pages = $wp_query->max_num_pages;
         if(!$pages){
             $pages = 1;
         }
     }   

     if(1 != $pages){
        //echo '<div class="text-center">'; 
        echo '<nav><ul class="pagination"><li class="disabled hidden-xs"><span><span aria-hidden="true">Page '.$paged.' of '.$pages.'</span></span></li>';
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."' aria-label='First'>&laquo;<span class='hidden-xs'> First</span></a></li>";
         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."' aria-label='Previous'>&lsaquo;<span class='hidden-xs'> Previous</span></a></li>";
         for ($i=1; $i <= $pages; $i++){
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                 echo ($paged == $i)? "<li class=\"active\"><span>".$i." <span class=\"sr-only\">(current)</span></span> </li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\"  aria-label='Next'><span class='hidden-xs'>Next </span>&rsaquo;</a></li>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."' aria-label='Last'><span class='hidden-xs'>Last </span>&raquo;</a></li>";
         echo "</ul></nav>";
         //echo "</div>";
     }
}

define( 'WPUM_DISABLE_CSS', true );

add_filter('months_dropdown_results', 'test_remove_monthdropdown', 99);
function test_remove_monthdropdown($date) {
return array();
}

//defining the filter that will be used so we can select posts by 'author'
function add_author_filter_to_posts_administration(){

    //execute only on the 'post' content type
    global $post_type;
    if($post_type == 'post' || $post_type == 'favorite' || $post_type == 'lead' || $post_type == 'search'){

        //get a listing of all users that are 'author' or above
        $user_args = array(
            'show_option_all'   => 'All Users',
            'orderby'           => 'display_name',
            'order'             => 'ASC',
            'name'              => 'author_admin_filter',
            'who'               => 'authors',
            'include_selected'  => true
        );

        //determine if we have selected a user to be filtered by already
        if(isset($_GET['author_admin_filter'])){
            //set the selected value to the value of the author
            $user_args['selected'] = (int)sanitize_text_field($_GET['author_admin_filter']);
        }

        //display the users as a drop down
        if ( current_user_can( 'manage_options' ) ) {
            wp_dropdown_users($user_args);
        }
    }

}
add_action('restrict_manage_posts','add_author_filter_to_posts_administration');

//restrict the posts by an additional author filter
function add_author_filter_to_posts_query($query){

    global $post_type, $pagenow; 

    //if we are currently on the edit screen of the post type listings
    if($pagenow == 'edit.php' && ($post_type == 'post' || $post_type == 'favorite' || $post_type == 'lead' || $post_type == 'search' )){

        if(isset($_GET['author_admin_filter'])){

            //set the query variable for 'author' to the desired value
            $author_id = sanitize_text_field($_GET['author_admin_filter']);

            //if the author is not 0 (meaning all)
            if($author_id != 0){
                $query->query_vars['author'] = $author_id;
            }

        }
    }
}

add_action('pre_get_posts','add_author_filter_to_posts_query');



add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );

function wpse45436_admin_posts_filter_restrict_manage_posts(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('lead' == $type){
        //change this to the list of values you want to show
        //in 'label' => 'value' format
        $values = array(
            'Info Requests' => 'inforequest', 
            'Property inquiry' => 'Property inquiry',
            'Thinking about buying' => 'Thinking about buying',
            'Thinking about selling' => 'Thinking about selling',
            'Just curious' => 'Just curious',
            'Home Valuation' => 'Home Valuation',
            'Quick Contact' => 'Quick Contact',
        );

        ?>
        <select name="lead_type">
        <option value=""><?php _e('Filter By ', 'wose45436'); ?></option>
        <?php
            $current_v = isset($_GET['lead_type'])? $_GET['lead_type']:'';
            foreach ($values as $label => $value) {
                printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_v? ' selected="selected"':'',
                        $label
                    );
                }
        ?>
        </select>
        <?php
    }
}


add_filter( 'parse_query', 'wpse45436_posts_filter' );

function wpse45436_posts_filter( $query ){
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'lead' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['lead_type']) && $_GET['lead_type'] != '') {
        $query->query_vars['meta_key'] = 'lead_info_lead_type';
        $query->query_vars['meta_value'] = $_GET['lead_type'];
    }
}

//remove stuff agents shouldn't see
function wpse28782_remove_menu_items() {
    if( !current_user_can( 'administrator' ) ):
        remove_menu_page( 'edit.php?post_type=lead' );
        remove_menu_page( 'edit.php?post_type=search' );
        remove_menu_page( 'edit.php?post_type=favorite' );
        remove_menu_page( 'edit.php?post_type=fprop' );
    endif; 
} 
add_action( 'admin_menu', 'wpse28782_remove_menu_items' );

function removeActionLinks($views){
    if( current_user_can( 'manage_options' ) )
        return $views;

    $remove_views = [ 'all','publish','future','sticky','draft','pending','trash' ];

    foreach( (array) $remove_views as $view ){
        if( isset( $views[$view] ) )
            unset( $views[$view] );
    }
    return $views;
} 

function hide_admin_bar_search () {
	echo '<style type="text/css">
	#posts-filter .search-box {
		display: none;
	}
	</style>';
}
add_action('admin_head', 'hide_admin_bar_search');
add_action('wp_head', 'hide_admin_bar_search');

function add_theme_caps() {
    // gets the author role
    $authorrole = get_role( 'author' );

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $authorrole->add_cap( 'edit_agents' ); 
    //$role->add_cap( 'read_agents' );
    //$role->remove_cap( 'edit_others_agents' );
  
    $adminrole = get_role( 'administrator' );
    $adminrole->add_cap( 'edit_agents' ); 
    $adminrole->add_cap( 'publish_agents' ); 
    $adminrole->add_cap( 'edit_others_agents' ); 
  
}
add_action( 'admin_init', 'add_theme_caps');

add_filter( 'views_edit-lead', 'removeActionLinks' );
add_filter( 'views_edit-favorite', 'removeActionLinks' );
add_filter( 'views_edit-search', 'removeActionLinks' );
add_filter( 'views_edit-agent', 'removeActionLinks' );

// [getfavorites num="" ]
function getfavorites_func( $atts, $content = null ) {
    $favorites = new Favorites();
    $listings = $favorites->getfavorites();
    ?>
    <div class="row justify-content-center align-items-center text-center">
        <?php foreach($listings as $listing){ ?>
            <div class="feat-prop col-md-6 col-xl-3 text-center">
                <?php include(locate_template('template-parts/partials/mini-listing.php')); ?>
            </div>
        <?php } ?>
    </div>
    <?php
}
add_shortcode( 'getfavorites', 'getfavorites_func' );



/////////////////
//REMOVE DEFAULT DASHBOARD WIDGETS
function remove_dashboard_meta() {
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
  
    remove_meta_box( 'wpum_dashboard_users', 'dashboard', 'normal' ); //WP USERMANAGER
    remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' ); //YOAST SEO
  
}
add_action( 'admin_init', 'remove_dashboard_meta' );


//ADD QUICK CONTACT LEADS DASHBOARD WIDGET
function add_leads_dashboard_widget() {

	wp_add_dashboard_widget(
         'leads_dashboard_widget',         // Widget slug.
         'My Quick Contact Leads',         // Title.
         'leads_dashboard_widget_function' // Display function.
    );	
}
add_action( 'wp_dashboard_setup', 'add_leads_dashboard_widget' );

function leads_dashboard_widget_function() {
  
    $current_user = wp_get_current_user(); 
  
    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 0,
        'role__in'     => array(),
        'role__not_in' => array(),
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => array(),
        'date_query'   => array(),        
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'login',
        'order'        => 'ASC',
        'offset'       => '',
        'search'       => '',
        'number'       => '', 
        'count_total'  => false,
        'fields'       => 'all',
        'who'          => ''
    ); 
    $userlist = get_users( $args );
    
    $numleads = 0;
  
    foreach($userlist as $lead){
        //print_r($lead);
        echo '<div class="lead" >';
                
        $request = array(
            'posts_per_page'  => 10,
            'offset'          => 0,
            'order'           => 'DESC',
            'orderby'   	  => 'post_date',
            'post_type'       => 'Lead',
            'post_status'     => 'publish',	
            'author'          => $lead->ID,
            'meta_query' => array(
                 array(
                     'key' => 'lead_info_lead_type',
                     'value' => 'Quick Contact',
                     'compare' => '=',
                 )
             )
        );

        $favlist = get_posts( $request );  
      
        foreach($favlist as $leadfav){
                    
            $myagent = get_user_meta($lead->ID, 'your_agent', true);
            $leadowner = str_replace(' ', '-', strtolower($current_user->display_name));
            if($myagent == ''){ $leadowner = 'zach-childs'; } 

            if(($myagent == $leadowner && $myagent != '') || current_user_can( 'manage_options' )){ 
              
                if($myagent != ''){
                    if($leadowner == 'kma' || $leadowner == 'zach-childs') { $admininfo = ' ( assigned to '.ucwords(str_replace('-',' ',$myagent)).' )'; } else { $admininfo = ''; }
                }else{
                    if($leadowner == 'kma' || $leadowner == 'zach-childs') { $admininfo = ' ( no agent selected )'; } else { $admininfo = ''; }
                }

                echo '<p><a class="button button-info pull-right" style="float:right;" href="'.get_edit_post_link($leadfav->ID).'">View</a><strong>'.$leadfav->lead_info_name.$admininfo.'</strong>'.
                     '<br>'.$leadfav->lead_info_phone_number.
                     '<br>'.'<a href="'.$leadfav->lead_info_email_address.'" >'.$leadfav->lead_info_email_address.'</a>'.
                     '<br>'.$leadfav->lead_info_date.'</p><hr>';
              
                $numleads++;
            }
              
        }
            
        echo '</div>';
    }
    if( current_user_can( 'manage_options' ) ){
        echo '<a class="button button-primary" href="/wp-admin/edit.php?s&post_status=all&post_type=lead&action=-1&author_admin_filter=0&lead_type[]=Quick+Contact&filter_action=Filter&paged=1&action2=-1" >All Leads ('.$numleads.')</a>';
    }
}

//ADD Home Valuation LEADS DASHBOARD WIDGET
function add_homeval_dashboard_widget() {

	wp_add_dashboard_widget(
         'homeval_dashboard_widget',         // Widget slug.
         'My Home Valuation Leads',         // Title.
         'homeval_dashboard_widget_function' // Display function.
    );	
}
add_action( 'wp_dashboard_setup', 'add_homeval_dashboard_widget' );

function homeval_dashboard_widget_function() {
  
    $current_user = wp_get_current_user(); 
  
    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 0,
        'role__in'     => array(),
        'role__not_in' => array(),
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => array(),
        'date_query'   => array(),        
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'login',
        'order'        => 'ASC',
        'offset'       => '',
        'search'       => '',
        'number'       => '', 
        'count_total'  => false,
        'fields'       => 'all',
        'who'          => ''
    ); 
    $userlist = get_users( $args );
    
    $numleads = 0;
  
    foreach($userlist as $lead){
        //print_r($lead);
        echo '<div class="lead" >';
                
        $request = array(
            'posts_per_page'  => 10,
            'offset'          => 0,
            'order'           => 'DESC',
            'orderby'   	  => 'post_date',
            'post_type'       => 'Lead',
            'post_status'     => 'publish',	
            'author'          => $lead->ID,
            'meta_query' => array(
                 array(
                     'key' => 'lead_info_lead_type',
                     'value' => 'Home Valuation',
                     'compare' => '=',
                 )
             )
        );

        $favlist = get_posts( $request );  
      
        foreach($favlist as $leadfav){
                    
            $myagent = get_user_meta($lead->ID, 'your_agent', true);
            $leadowner = str_replace(' ', '-', strtolower($current_user->display_name));
            if($myagent == ''){ $leadowner = 'zach-childs'; } 

            if(($myagent == $leadowner && $myagent != '') || current_user_can( 'manage_options' )){ 
              
                if($myagent != ''){
                    if($leadowner == 'kma' || $leadowner == 'zach-childs') { $admininfo = ' ( assigned to '.ucwords(str_replace('-',' ',$myagent)).' )'; } else { $admininfo = ''; }
                }else{
                    if($leadowner == 'kma' || $leadowner == 'zach-childs') { $admininfo = ' ( no agent selected )'; } else { $admininfo = ''; }
                }

                echo '<p><a class="button button-info pull-right" style="float:right;" href="'.get_edit_post_link($leadfav->ID).'">View</a><strong>'.$leadfav->lead_info_name.$admininfo.'</strong>'.
                     '<br>'.$leadfav->lead_info_phone_number.
                     '<br>'.'<a href="'.$leadfav->lead_info_email_address.'" >'.$leadfav->lead_info_email_address.'</a>'.
                     '<br>'.$leadfav->lead_info_date.'</p><hr>';
              
                $numleads++;
            }
              
        }
            
        echo '</div>';
    }
    if( current_user_can( 'manage_options' ) ){
        echo '<a class="button button-primary" href="/wp-admin/edit.php?s&post_status=all&post_type=lead&action=-1&author_admin_filter=0&lead_type[]=Home+Valuation&filter_action=Filter&paged=1&action2=-1" >All Leads ('.$numleads.')</a>';
    }
}

//ADD Property Inquiries LEADS DASHBOARD WIDGET
function add_requestinfo_dashboard_widget() {

	wp_add_dashboard_widget(
         'requestinfo_dashboard_widget',           // Widget slug.
         'My Info Requests (Contact Page)',         // Title.
         'requestinfo_dashboard_widget_function' // Display function.
    );	
}
add_action( 'wp_dashboard_setup', 'add_requestinfo_dashboard_widget' );

function requestinfo_dashboard_widget_function() {
  
    $current_user = wp_get_current_user(); 
  
    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 0,
        'role__in'     => array(),
        'role__not_in' => array(),
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => array(),
        'date_query'   => array(),        
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'login',
        'order'        => 'ASC',
        'offset'       => '',
        'search'       => '',
        'number'       => '', 
        'count_total'  => false,
        'fields'       => 'all',
        'who'          => ''
    ); 
    $userlist = get_users( $args );
    
    $numleads = 0;
  
    foreach($userlist as $lead){
        //print_r($lead);
        echo '<div class="lead" >';
                
        $request = array(
            'posts_per_page'  => 10,
            'offset'          => 0,
            'order'           => 'DESC',
            'orderby'   	  => 'post_date',
            'post_type'       => 'Lead',
            'post_status'     => 'publish',	
            'author'          => $lead->ID,
            'meta_query' => array(
                 'relation' => 'OR',
                 array(
                     'key' => 'lead_info_lead_type',
                     'value' => 'Property inquiry',
                     'compare' => '=',
                 ),
                 array(
                     'key' => 'lead_info_lead_type',
                     'value' => 'requestinfo',
                     'compare' => '=',
                 ),
                 array(
                     'key' => 'lead_info_lead_type',
                     'value' => 'Thinking about buying',
                     'compare' => '=',
                 ),
                 array(
                     'key' => 'lead_info_lead_type',
                     'value' => 'Thinking about selling',
                     'compare' => '=',
                 ),
                 array(
                     'key' => 'lead_info_lead_type',
                     'value' => 'Just curious',
                     'compare' => '=',
                 )
             )
        );

        $favlist = get_posts( $request );  
      
        foreach($favlist as $leadfav){
                    
            $myagent = get_user_meta($lead->ID, 'your_agent', true);
            $leadowner = str_replace(' ', '-', strtolower($current_user->display_name));
            if($myagent == ''){ $leadowner = 'zach-childs'; } 

            if(($myagent == $leadowner && $myagent != '') || current_user_can( 'manage_options' )){ 
              
                if($myagent != ''){
                    if($leadowner == 'kma' || $leadowner == 'zach-childs') { $admininfo = ' ( assigned to '.ucwords(str_replace('-',' ',$myagent)).' )'; } else { $admininfo = ''; }
                }elseif($leadfav->lead_info_phone_number != ''){
                    if($leadowner == 'kma' || $leadowner == 'zach-childs') { $admininfo = ' ( sent to '.$leadfav->lead_info_selected_agent.' )'; } else { $admininfo = ''; }
                }else{
                    if($leadowner == 'kma' || $leadowner == 'zach-childs') { $admininfo = ' ( no agent selected )'; } else { $admininfo = ''; }
                }
              
                $leaddetail = $leadfav->lead_info_lead_type;
                if($leadfav->lead_info_mls != ''){ $leaddetail .= ' ('.$leadfav->lead_info_mls.')'; }

                echo '<p><a class="button button-info pull-right" style="float:right;" href="'.get_edit_post_link($leadfav->ID).'">View</a><strong>'.$leadfav->lead_info_name.$admininfo.'</strong>'.
                     '<br>'.$leadfav->lead_info_phone_number.
                     '<br>'.$leaddetail.
                     '<br>'.'<a href="'.$leadfav->lead_info_email_address.'" >'.$leadfav->lead_info_email_address.'</a>'.
                     '<br>'.$leadfav->lead_info_date.'</p><hr>';
              
                $numleads++;
            }
              
        }
            
        echo '</div>';
    }
    if( current_user_can( 'manage_options' ) ){
        echo '<a class="button button-primary" href="/wp-admin/edit.php?s&post_status=all&post_type=lead&action=-1&author_admin_filter=0&lead_type[]=requestinfo&lead_type[]=Property+inquiry&lead_type[]=Just+curious&lead_type[]=Thinking+about+buying&lead_type[]=Thinking+about+selling&filter_action=Filter&paged=1&action2=-1" >All Leads ('.$numleads.')</a>';
    }
}


//ADD CUSTOMERS DASHBOARD WIDGET
function add_clients_dashboard_widget() {
    
	wp_add_dashboard_widget(
         'clients_dashboard_widget',         // Widget slug.
         'My Customers',         // Title.
         'clients_dashboard_widget_function' // Display function.
    );	
}
add_action( 'wp_dashboard_setup', 'add_clients_dashboard_widget' );

function clients_dashboard_widget_function() {
  
    $current_user = wp_get_current_user(); 
    
    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        //'role'         => 'Subscriber',
        'role__in'     => array(),
        'role__not_in' => array(),
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => array(),
        'date_query'   => array(),        
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'login',
        'order'        => 'ASC',
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
  
    foreach($clientlist as $client){ 
      
        $myagent = get_user_meta($client->ID, 'your_agent', true);
        $leadowner = str_replace(' ', '-', strtolower($current_user->display_name));
        //if($myagent == ''){ $leadowner = 'zach-childs'; } 
      
        //print_r($client->roles[0]);
        
        if( ($myagent == $leadowner && $myagent != '') || ( current_user_can( 'manage_options' ) && $client->roles[0] == 'subscriber' )  ){ 
          
          //get counts
          $favlist = get_posts( array(
              'posts_per_page'  => -1, 
              'orderby'   	    => 'post_date',
              'post_type'       => 'favorite',
              'post_status'     => 'publish',	
              'author'          => $client->ID
          ) );  
          
          $numfavs = count( $favlist );
          
          $searchlist = get_posts( array(
              'posts_per_page'  => -1,
              'orderby'   	    => 'post_date',
              'post_type'       => 'search',
              'post_status'     => 'publish',	
              'author'          => $client->ID
          ) );  
          
          $numsearches = count( $searchlist );
          
          if($myagent != ''){
              if($leadowner == 'kma' || $leadowner == 'zach-childs') { $admininfo = ' ( assigned to '.ucwords(str_replace('-',' ',$myagent)).' )'; } else { $admininfo = ''; }
              if($leadowner == 'kma' || $leadowner == 'zach-childs') { 
                  $admininfo = ' ( no agent selected )'; 
                  $admininfo .= ' <a href="#TB_inline?width=300&height=200&inlineId=assignagent'.$client->ID.'" role="button" data-toggle="modal" class="button button-info thickbox" style="float:right;" >Change Agent</a>';
              } else { $admininfo = ''; }
          }else{
              if($leadowner == 'kma' || $leadowner == 'zach-childs') { 
                  $admininfo = ' ( no agent selected )'; 
                  $admininfo .= ' <a href="#TB_inline?width=300&height=200&inlineId=assignagent'.$client->ID.'" role="button" data-toggle="modal" class="button button-info thickbox" style="float:right;" >Assign Agent</a>';
              } else { $admininfo = ''; }
          }
          $name = $client->display_name.$admininfo;
          
          
          
          //show info
          echo '<p><strong>'.$client->display_name.$admininfo.'</strong>'.
                 '<br>'.'<a href="'.$client->user_email.'" >'.$client->user_email.'</a></p>
                 <a class="button button-primary" href="/wp-admin/edit.php?s&post_status=all&post_type=search&action=-1&m=0&author_admin_filter='.$client->ID.'&filter_action=Filter&paged=1&action2=-1">View Searches ('.$numsearches.')</a> <a class="button button-primary" href="/wp-admin/edit.php?s&post_status=all&post_type=favorite&action=-1&m=0&author_admin_filter='.$client->ID.'&filter_action=Filter&paged=1&action2=-1">View Favorites ('.$numfavs.')</a>';
          
          echo '<hr>';
          
        }
        
        
        add_thickbox();
        echo '<div id="assignagent'.$client->ID.'" class="modal hide fade" style="display:none;">

                

                <div style="margin:20px;">
                    <h3>Assign Agent to this Customer</h3>
                    <p>Change this to associate the lead with an agent. Once selected, an email notification will be sent to the agent.<br>Selecting "First Available" will not make any changes.</p>
                    <form class="form" id="agentselect"  enctype="multipart/form-data" method="post" action="#agent-select-form">
                        <input type="hidden" name="formID" value="agentselect" >
                        <input type="hidden" name="cid" value="'.$client->ID.'">
                        <input type="hidden" name="cname" value="'.$client->display_name.'">
                        <input type="hidden" name="cemail" value="'.$client->user_email.'">
                        <label>Select Agent: </label>
                        <select class="form-control" name="youragent">
                            <option value="" >First Available</option>';
                            foreach($agentarray as $agent){
                              if($agent['showindropdown']=='on'){
                                echo '<option value="'.$agent['slug'].'" >'.$agent['name'].'</option>';
                              }
                            }
                        echo '</select>

                        <input type="text" name="secu" style="position: absolute; height: 1px; top: -50px; left: -50px; width: 1px; padding: 0; margin: 0; visibility: hidden;" >
                        <button type="submit" class="button button-primary" >SAVE</button>

                    </form>
                </div>
            </div>';
        
    }
  
  
    

    if(isset($_POST['secu']) && $_POST['secu'] == '' && isset($_POST['formID']) && $_POST['formID'] == 'agentselect'){
        if($_POST['youragent']!=''){
            if( get_user_meta( $_POST['cid'], 'your_agent', true) ){
                update_user_meta( $_POST['cid'], 'your_agent', $_POST['youragent'] );
            } else {
                add_user_meta( $_POST['cid'], 'your_agent', $_POST['youragent'] );
            }
        }
      
        $mlsLead = new mlsLeads();
      
        foreach($agentarray as $agent){
            if( $_POST['youragent'] == $agent['slug'] ){ 
                $adminemail = $agent['email'];
                $agentName = $agent['name'];
            }
        }
            
        $postvars = array(
            'Name' => $_POST['cname'],
            'Email Address' => $_POST['cemail'],
            //'Phone Number' => $ph1.'-'.$ph2.'-'.$ph3,
            //'Additional Info' => htmlentities(stripslashes($_POST['additionalinfo'])),
        );
      
        $sendadmin = array(
            'to'		=> $adminemail,
            'from'		=> get_bloginfo().' <noreply@98realestategroup.com>',
            'subject'	=> 'You have been assigned a new lead from the website',
            'bcc'		=> 'support@kerigan.com',
        );

        $fontstyle = 'font-family: sans-serif;';
        $headlinestyle = 'style="font-size:20px; '.$fontstyle.' color:#C41230;"';
        $copystyle = 'style="font-size:16px; '.$fontstyle.' color:#333;"';
        $labelstyle = 'style="padding:4px 8px; background:#F7F6F3; border:1px solid #E3E0D3; font-weight:bold; '.$fontstyle.' font-size:14px; color:#4D4B47; width:150px;"';
        $datastyle = 'style="padding:4px 8px; background:#F7F6F3; border:1px solid #E3E0D3; '.$fontstyle.' font-size:14px;"';

        $headline = '<h2 '.$headlinestyle.'>New Lead Assignment</h2>';	
        $adminintrocopy = '<p '.$copystyle.'>You have been assigned a new lead from the website. Details are below:</p>';
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
      
        echo '<script>parent.window.location.reload();</script>';
      
    }

    //delete_usermeta( 25, 'your_agent' );
  
  //print_r($current_user);
  
}