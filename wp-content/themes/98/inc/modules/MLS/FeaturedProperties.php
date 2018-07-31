<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class FeaturedProperties
{

    /**
     * Featured Properties constructor.
     * configure any options here
     */
    public function __construct ()
    {
        add_action( 'init', [$this, 'createPostType']);
        //add_action( 'admin_init', [$this, 'addMetaBoxes']);
        add_filter ('manage_edit-fprop_columns', [$this, 'editColumns']);
        add_action ('manage_fprop_custom_column', [$this, 'customColumns']);
        add_action ('save_fprop', [$this, 'savePost']);
        add_filter('fprop_updated_messages', [$this, 'postMessages']);
    }

    public function createPostType()
    {
        register_post_type( 'fprop', array(
            'labels'             => array(
                'name' 		         => _x( 'Featured Properties', 'post type general name' ),
                'singular_name'      => _x( 'Featured Property', 'post type singular name' ),
                'menu_name'          => _x( 'Featured Properties', 'admin menu' ),
                'name_admin_bar'     => _x( 'Featured Properties', 'add new on admin bar' ),
                'add_new'            => _x( 'Add New', 'featured property' ),
                'add_new_item'       => __( 'Add New Featured Property' ),
                'new_item'           => __( 'New Featured Property' ),
                'edit_item'          => __( 'Edit Featured Property' ),
                'view_item'          => __( 'View Featured Property' ),
                'all_items'          => __( 'All Featured Properties' ),
                'search_items'       => __( 'Search Featured Properties' ),
                'parent_item_colon'  => __( 'Parent Property:' ),
                'not_found'          => __( 'No featured propertes found.' ),
                'not_found_in_trash' => __( 'No featured properties found in Trash.' )
            ),
            'public'             => true,
            'menu_icon'		   => 'dashicons-star-filled',
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'all-fprop', 'with_front' => FALSE ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title' )
          ));
    }

    function postMeta() 
    {         
        global $post;

        $custom = get_post_custom($post->ID);    
         
        echo '<input type="hidden" name="fprop-nonce" id="fprop-nonce" value="' .
        wp_create_nonce( 'fprop-nonce' ) . '" />';
    }

    public function addMetaBoxes()
    {
        add_meta_box('fprop_meta', 'Member Info', [$this, 'postMeta'], 'fprop');
    }

    public function editColumns($columns)
    {
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "MLS#",
        );
        return $columns;
    }

    public function customColumns($column)
    {
        global $post;

        $custom = get_post_custom();
    }

    public function savePost()
    {
        global $post;
               
        if ( !wp_verify_nonce( $_POST['fprop-nonce'], 'fprop-nonce' )) {
            return $post->ID;
        }
        
        if ( !current_user_can( 'edit_post', $post->ID ))
            return $post->ID;
    }

    public function postMessages( $messages ) {
 
        global $post, $post_ID;
       
        $messages['fprop'] = array(
          0 => '', // Unused. Messages start at index 1.
          1 => sprintf( __('Team member updated. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
          2 => __('Custom field updated.'),
          3 => __('Custom field deleted.'),
          4 => __('Team member updated.'),
          /* translators: %s: date and time of the revision */
          5 => isset($_GET['revision']) ? sprintf( __('Team member restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
          6 => sprintf( __('Team member published. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
          7 => __('Team member saved.'),
          8 => sprintf( __('Team member submitted. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
          9 => sprintf( __('Team member scheduled to post on: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview member</a>'),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
          10 => sprintf( __('Team member draft updated. <a target="_blank" href="%s">Preview member</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );
       
        return $messages;
      }

      public function getFeaturedProp()
      {    
        $getFprop = get_posts( array( 
            'post_type'         => 'fprop',
            'posts_per_page'	=> -1,
            'orderby'			=> 'menu_order',
            'order'             => 'ASC',
            'offset'			    => 0,
            'post_status'		=> 'publish',
        ) );

        $featuredList = [];
        
        foreach ( $getFprop as $fprop ){            
            $featuredList[] = $fprop->post_title;
        }

        $client     = new Client(['base_uri' => 'https://rafgc.kerigan.com/api/v1/']);
        $mlsNumbers = implode('|', $featuredList);

        $apiCall = $client->request(
            'GET', 'listings?mlsNumbers=' . $mlsNumbers
        );

        $results = json_decode($apiCall->getBody());

        return $results->data;
    }

}