<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;
use KeriganSolutions\CPT\CustomPostType;

class Favorites {

    public function __construct()
    {
    }

    public function setupAdmin()
    {
        $this->createPostType();
    }

    public function createPostType()
    {
        $favorite = new CustomPostType(
            'Favorite',
            [
                'supports'           => ['title'],
                'menu_icon'          => 'dashicons-star-empty',
                'has_archive'        => false,
                'menu_position'      => null,
                'public'             => false,
                'publicly_queryable' => false,
            ]
        );

        $favorite->addMetaBox(
            'Favorite Info', [
                'MLSnum' => 'locked',
                'Date' => 'locked',
                'Username' => 'locked',
                'User Email' => 'locked',
                'Name' => 'locked',
                'UserID' => 'locked'
            ]
        );
    }

    public function getfavorites()
    {
        if(is_user_logged_in()){
            $user_id = get_current_user_id();

            $request = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'post_type'        => 'Favorite',
                'post_status'      => 'publish',
                'post_author'      => $user_id
            );

            $favs = get_posts( $request );
            $favList = [];

            foreach ( $favs as $fav ){
                $favList[] = $fav->favorite_info_mlsnum;
            }

            $client     = new Client(['base_uri' => 'https://navica.kerigan.com/api/v1/']);
            $mlsNumbers = implode('|', $favList);

            $apiCall = $client->request(
                'GET', 'listings?mlsNumbers=' . $mlsNumbers
            );

            $results = json_decode($apiCall->getBody());

            return $results->data;

        }else{
            return FALSE;
        }
    }

    /**
	 * Add REST API routes
	 */
    public function addRoutes()
    {
        register_rest_route( 'kerigansolutions/v1', '/add-favorite',
            [
                'methods'         => 'POST',
                'callback'        => [ $this, 'addFavorite' ]
            ]
        );

        register_rest_route( 'kerigansolutions/v1', '/delete-favorite',
            [
                'methods'         => 'POST',
                'callback'        => [ $this, 'deleteFavorite' ]
            ]
        );
    }

    /*
    * Function to check whether a MLS property is in the list of favorites for current user.
    * TRUE: is listed; FALSE: is not listed
    */
    public function checkFavorites( $mls, $userId )
    {
        if(is_user_logged_in()){

            $request = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'post_type'        => 'Favorite',
                'post_status'      => 'publish',
                'post_author'      => $userId,
                'meta_key'         => 'favorite_info_mlsnum',
                'meta_value'       => $mls
            );

            $favs= get_posts( $request );

            if(count($favs)>0){
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    public function addFavorite( $mls )
    {
        $mls = (isset($_GET['mls']) ? $_GET['mls'] : $mls);
        $current_user = get_user_by('ID', (isset($_GET['userid']) ? $_GET['userid'] : get_current_user_id()));

        $postContent = [
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'Favorite',
            'post_title' => 'Favorite - '.$mls.' - '.$current_user->display_name,
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'meta_input' => [ //POST META
                'favorite_info_mlsnum' => $mls,
                'favorite_info_date' => date('M j, Y').' @ '.date('g:i a e'),
                'favorite_info_username' => $current_user->user_login,
                'favorite_info_user_email' => $current_user->user_email,
                'favorite_info_name' => $current_user->display_name,
                'favorite_info_userid' => $current_user->ID
            ]
        ];

        return wp_insert_post( $postContent, true );
    }

    public function deleteFavorite( $mls )
    {
        $mls = (isset($_GET['mls']) ? $_GET['mls'] : $mls);
        $user_id = (isset($_GET['userid']) ? $_GET['userid'] : get_current_user_id());

        $request = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'post_type'        => 'Favorite',
            'post_status'      => 'publish',
            'post_author'      => $user_id,
            'meta_key'         => 'favorite_info_mlsnum',
	        'meta_value'       => $mls,
        );

        $favs= get_posts( $request );

        foreach($favs as $dFav){
            wp_delete_post( $dFav->ID );
        }
    }
}