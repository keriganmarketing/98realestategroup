<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class HotDeals
{

    /**
     * Hot Deals constructor.
     * configure any options here
     */
    public function __construct ()
    {
        add_action( 'init', [$this, 'createPostType']);
        //add_action( 'admin_init', [$this, 'addMetaBoxes']);
        add_filter ('manage_edit-hot-deal_columns', [$this, 'editColumns']);
        add_action ('manage_hot-deal_custom_column', [$this, 'customColumns']);
        add_action ('save_hot-deal', [$this, 'savePost']);
        add_filter('hot-deal_updated_messages', [$this, 'postMessages']);
    }

    public function createPostType()
    {
        register_post_type( 'hot-deal', array(
            'labels'             => array(
                'name' 		         => _x( 'Hot Deals', 'post type general name' ),
                'singular_name'      => _x( 'Hot Deal', 'post type singular name' ),
                'menu_name'          => _x( 'Hot Deals', 'admin menu' ),
                'name_admin_bar'     => _x( 'Hot Deals', 'add new on admin bar' ),
                'add_new'            => _x( 'Add New', 'Hot Deal' ),
                'add_new_item'       => __( 'Add New Hot Deal' ),
                'new_item'           => __( 'New Hot Deal' ),
                'edit_item'          => __( 'Edit Hot Deal' ),
                'view_item'          => __( 'View Hot Deal' ),
                'all_items'          => __( 'All Hot Deals' ),
                'search_items'       => __( 'Search Hot Deals' ),
                'parent_item_colon'  => __( 'Parent Deal:' ),
                'not_found'          => __( 'No Hot propertes found.' ),
                'not_found_in_trash' => __( 'No Hot Deals found in Trash.' )
            ),
            'public'             => true,
            'menu_icon'		   => 'dashicons-star-filled',
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'hot-deals', 'with_front' => FALSE ),
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

        echo '<input type="hidden" name="hot-deal-nonce" id="hot-deal-nonce" value="' .
        wp_create_nonce( 'hot-deal-nonce' ) . '" />';
    }

    public function addMetaBoxes()
    {
        add_meta_box('hot-deal_meta', 'Member Info', [$this, 'postMeta'], 'hot-deal');
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

        if ( !wp_verify_nonce( $_POST['hot-deal-nonce'], 'hot-deal-nonce' )) {
            return $post->ID;
        }

        if ( !current_user_can( 'edit_post', $post->ID ))
            return $post->ID;
    }

    public function postMessages( $messages ) {

        global $post, $post_ID;

        $messages['hot-deal'] = array(
          0 => '', // Unused. Messages start at index 1.
          1 => sprintf( __('Hot deal updated. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
          2 => __('Custom field updated.'),
          3 => __('Custom field deleted.'),
          4 => __('Hot deal updated.'),
          /* translators: %s: date and time of the revision */
          5 => isset($_GET['revision']) ? sprintf( __('Hot deal restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
          6 => sprintf( __('Hot deal published. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
          7 => __('Hot deal saved.'),
          8 => sprintf( __('Hot deal submitted. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
          9 => sprintf( __('Hot deal scheduled to post on: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview deal</a>'),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
          10 => sprintf( __('Hot deal draft updated. <a target="_blank" href="%s">Preview deal</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );

        return $messages;
      }

      public function getHotProp()
      {
        $getHotDeal = get_posts( array(
            'post_type'         => 'hot-deal',
            'posts_per_page'	=> -1,
            'offset'			=> 0,
            'post_status'		=> 'publish',
        ) );

        $HotList = [];

        foreach ( $getHotDeal as $hotDeal ){
            $HotList[] = $hotDeal->post_title;
        }

        $client     = new Client(['base_uri' => 'https://navica.kerigan.com/api/v1/']);
        $mlsNumbers = implode('|', $HotList);

        $apiCall = $client->request(
            'GET', 'listings?mlsNumbers=' . $mlsNumbers
        );

        $results = json_decode($apiCall->getBody());

        return $results->data;
    }

    public function getUrlBuilder(){
        $request = (isset($_GET['mlsnumbers']) ? $_GET['mlsnumbers'] : []);

        $mlsNums = explode(' ', $request);

        $client     = new Client(['base_uri' => 'https://navica.kerigan.com/api/v1/']);
        $mlsNumbers = implode('|', $mlsNums);

        $apiCall = $client->request(
            'GET', 'listings?mlsNumbers=' . $mlsNumbers
        );

        $results = json_decode($apiCall->getBody());

        return $results->data;
    }

}