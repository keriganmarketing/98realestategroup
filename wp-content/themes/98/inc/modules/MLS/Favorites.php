<?php

namespace Includes\Modules\MLS; 

class Favorites {

    public function __construct()
    {
    }

    /*
    * Function to check whether a MLS property is in the list of favorites for current user.
    * TRUE: is listed; FALSE: is not listed
    */
    public function checkFavorites( $mls )
    {
        if(is_user_logged_in()){
            $user_id = get_current_user_id();

            $request = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'post_type'        => 'Favorite',
                'post_status'      => 'publish',	
                'author'           => $user_id,
                'meta_key'         => 'favorite_info_mlsnum',
                'meta_value'       => $mls,
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
    
     public function deleteFavorites( $mls )
     {
        $user_id = get_current_user_id();
        
        $request = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'post_type'        => 'Favorite',
            'post_status'      => 'publish',	
            'author'           => $user_id,
            'meta_key'         => 'favorite_info_mlsnum',
	        'meta_value'       => $mls,
        );

        $favs= get_posts( $request );
        
        foreach($favs as $dFav){
            wp_delete_post( $dFav->ID );
        } 
    }
}