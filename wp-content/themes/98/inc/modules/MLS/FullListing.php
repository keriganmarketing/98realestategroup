<?php
namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class FullListing
{
    protected $mlsNumber;
    protected $listingInfo;
    public $media;

    /**
     * Search Constructor
     * @param string $mlsNumber - Basically just the $_GET variables
     */
    public function __construct()
    {
        $this->getMlsNumber();
    }

    public function getListingInfo($mls = null)
    {
        if(isset($this->listingInfo->data)){
            return $this->listingInfo->data;
        }else{
            if(isset($mls)){
                $this->mlsNumber = $mls;
                $this->create();
                $this->assembleMedia();
                return $this->listingInfo->data;
            }
        }
    }

    public function getMlsNumber()
    {
        $pathFragments = explode('listing/',$_SERVER['REQUEST_URI']);
        $this->mlsNumber = str_replace('/','',end($pathFragments));

        if(strlen($this->mlsNumber) > 3 && is_numeric($this->mlsNumber)){    
            add_filter( 'template_include', function(){
                status_header(200, 'OK');
                $this->create();
                $this->assembleMedia();
                $this->setListingSeo();
                return TEMPLATEPATH . '/page-listing.php';
            } ) ;
        }
    }

    public function create()
    {
        $client  = new Client(['base_uri' => 'https://navica.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', 'listing/' . $this->mlsNumber
        );

        $results = json_decode($apiCall->getBody());
        $this->listingInfo = $results;

        return $results; 
    }

    public function setListingSeo()
    {
        add_filter('wpseo_title', function () {
            $title = $this->listingInfo->data->street_num . ' ' . $this->listingInfo->data->street_name;
            $title = ($this->listingInfo->data->unit_num != '' ? $title . ' ' . $this->listingInfo->data->unit_num : $title);
            $metaTitle = $title . ' | $' . number_format($this->listingInfo->data->price) . ' | ' . $this->listingInfo->data->city . ' | ' . get_bloginfo('name');
            return $metaTitle;
        });

        add_filter('wpseo_metadesc', function () {
            return strip_tags($this->listingInfo->data->remarks);
        });

        add_filter('wpseo_opengraph_image', function () {
            return ($this->media['photos'][0]->url != '' ? $this->media['photos'][0]->url : get_template_directory_uri() . '/img/nophoto.jpg');
        });

        add_filter('wpseo_canonical',  function () {
            return get_the_permalink() . $this->listingInfo->data->mls_account . '/';
        });

        add_filter('wpseo_opengraph_url', function ($ogUrl) {
            return get_the_permalink() . $this->listingInfo->data->mls_account . '/';
        }, 100, 1);
    }

    public function assembleMedia()
    {
        if(! $this->listingInfo->data->media_objects->data){
            return null;
        }

        $media  = $this->listingInfo->data->media_objects->data;
        $return = [ 'photos','vtours','docs','files','links'];

        //echo '<pre>',print_r($media),'</pre>';

        foreach($media as $var){
            if($var->media_type == 'image/jpeg'){ $return['photos'][] = $var; }
            if($var->media_type == 'Virtual Tour'){ $return['vtours'][] = $var; }
            if($var->media_type == 'Faxed in Documents'){ $return['docs'][] = $var; }
            if($var->media_type == 'File'){ $return['files'][] = $var; }
            if($var->media_type == 'Hyperlink'){ $return['links'][] = $var; }
        }

        $this->media = $return;
    }

    public function getMedia()
    {
        return $this->media;
    }
}