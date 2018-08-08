<?php
/**
 * Created by PhpStorm.
 * User: bbair
 * Date: 9/25/2017
 * Time: 8:51 PM
 */

namespace Includes\Modules\Team;

use KeriganSolutions\CPT\CustomPostType;

class Team
{
    public function __construct()
    {
    }

    public function setupAdmin()
    {
        $this->createPostType();
        $this->createAdminColumns();
        $this->setupShortcode();
    }

    public function createPostType()
    {
        $team = new CustomPostType(
            'Agent',
            [
                'supports'           => [ 'title', 'editor', 'author' ],
                'menu_icon'          => 'dashicons-businessman',
                'has_archive'        => false,
                'menu_position'      => null,
                'public'             => true,
                'publicly_queryable' => true,
                'hierarchical'       => true,
                'show_ui'            => true,
                'show_in_nav_menus'  => true,
                '_builtin'           => false,
                'rewrite'            => [
                    'slug'       => 'agent',
                    'with_front' => true,
                    'feeds'      => true,
                    'pages'      => false
                ]
            ]
        );

        $team->addTaxonomy('position');

        $team->addMetaBox(
            'Contact Info',
            [
                'Title'        => 'text',
                'Photo'        => 'image',
                'Email'        => 'text',
                'Office Phone' => 'text',
                'Cell Phone'   => 'text',
                'MLS ID'       => 'text',
                'AKA'          => 'text' 
            ]
        );

        $team->addMetaBox(
            'Social Media',
            [
                'Facebook'  => 'text',
                'Twitter'   => 'text',
                'Instagram' => 'text',
                'YouTube'   => 'text',
                'LinkedIn'  => 'text'
            ]
        );
    }

    /**
     * @return null
     */
    public function createAdminColumns()
    {
        add_filter(
            'manage_agent_posts_columns',
            function ($defaults) {
                $defaults = [
                    'title'       => 'Name',
                    'wtitle'      => 'Title',
                    'email'       => 'Email Address',
                    'photo'       => 'Photo'
                ];

                return $defaults;
            },
            0
        );

        add_action('manage_agent_posts_custom_column', function ($column_name, $post_ID) {
            switch ($column_name) {
                case 'photo':
                    $photo = get_post_meta($post_ID, 'contact_info_photo', true);
                    echo(isset($photo) ? '<img src ="' . $photo . '" class="img-fluid" style="width:150px; max-width:100%;" >' : null);
                    break;

                case 'email':
                    $object = get_post_meta($post_ID, 'contact_info_email', true);
                    echo(isset($object) ? date('M j, Y', strtotime($object)) : null);
                    break;

                case 'wtitle':
                    $object = get_post_meta($post_ID, 'contact_info_title', true);
                    echo(isset($object) ? date('M j, Y', strtotime($object)) : null);
                    break;
            }
        }, 0, 2);
    }

    public function getImageId($imageUrl) {
        $attachment_id = 0;

        $dir = wp_upload_dir();

        if ( false !== strpos( $imageUrl, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?

            $file = basename( $imageUrl );

            $query_args = array(
                'post_type'   => 'attachment',
                'post_status' => 'inherit',
                'fields'      => 'ids',
                'meta_query'  => array(
                    array(
                        'value'   => $file,
                        'compare' => 'LIKE',
                        'key'     => '_wp_attachment_metadata',
                    ),
                )
            );

            $query = new \WP_Query( $query_args );

            if ( $query->have_posts() ) {

                foreach ( $query->posts as $post_id ) {

                    $meta = wp_get_attachment_metadata( $post_id );
                    $original_file       = basename( $meta['file'] );
                    $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );

                    if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                        $attachment_id = $post_id;
                        break;
                    }

                }

            }

        }

        return $attachment_id;
    }

    public function getTeam($args = [])
    {
        $request = [
            'post_type'      => 'agent',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'offset'         => 0,
            'post_status'    => 'publish',
        ];

        $request = get_posts(array_merge($request, $args));

        $output = [];
        foreach ($request as $item) {

            $imageId = $this->getImageId($item->contact_info_photo);
            array_push($output, [
                'id'           => (isset($itemID) ? $item->ID : null),
                'name'         => $item->post_title,
                'title'        => (isset($item->contact_info_title) ? $item->contact_info_title : null),
                'email'        => (isset($item->contact_info_email) ? $item->contact_info_email : null),
                'office_phone' => (isset($item->contact_info_office_phone) ? $item->contact_info_office_phone : null),
                'cell_phone'   => (isset($item->contact_info_cell_phone) ? $item->contact_info_cell_phone : null),
                'slug'         => (isset($item->post_name) ? $item->post_name : null),
                'mlsid'        => (isset($item->contact_info_mls_id) ? $item->contact_info_mls_id : null),
                'images'       => [
                    'thumbnail' => wp_get_attachment_image_src($imageId, 'thumbnail'),
                    'medium'    => wp_get_attachment_image_src($imageId, 'medium'),
                    'large'     => wp_get_attachment_image_src($imageId, 'large'),
                    'full'      => wp_get_attachment_image_src($imageId, 'full')
                ],
                'link'         => get_permalink($item->ID),
            ]);
        }

        return $output;
    }

    public function getSingle($name)
    {
        $output = $this->getTeam([
            'title'          => $name,
            'posts_per_page' => 1,
        ]);

        return $output[0];
    }

    public function getSingleBySlug($slug)
    {
        $output = $this->getTeam([
            'slug'           => $slug,
            'posts_per_page' => 1,
        ]);

        return $output[0];
    }

    public function getTeamNames()
    {
        $request = $this->getTeam([]);

        $output = [];
        foreach ($request as $item) {
            array_push($output, (isset($item->post_title) ? $item->post_title : null));
        }

        return $output;
    }

    public function getAgentNames() {
		$request = get_posts( [
			'post_type'      => 'agent',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'offset'         => 0,
			'post_status'    => 'publish',
		] );

		$output = [];
		foreach ( $request as $item ) {
			array_push( $output, ( isset( $item->post_title ) ? $item->post_title : null ) );
		}

		return $output;
	}

    public function setupShortcode()
    {
        add_shortcode( 'team', function( $atts ){

            $data = $this->getTeam();
            ob_start();

            echo'<div class="columns is-multiline team">';
            foreach($data as $agent){
                include(locate_template('template-parts/partials/mini-team.php'));
            }
            echo '</div>';

            return ob_get_clean();

        } );
    }

    public function assembleAgentData( $agentName )
    {
        $agentData = $this->getSingle($agentName);
        return $agentData;
    }

    public function getAgentByMLS($mlsId)
    {
        $output = $this->getTeam([
            'meta_query' => [
                [
                    'key'     => 'contact_info_mls_id',
                    'value'   => $mlsId,
                    'compare' => 'LIKE',
                ]
            ]
        ]);

        return (isset($output[0]) ? $output[0] : null);
    }

}
