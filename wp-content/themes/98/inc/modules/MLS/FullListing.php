<?php
namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class FullListing
{
    protected $mlsNumber;
    protected $listingInfo;
    protected $media;

    /**
     * Search Constructor
     * @param string $mlsNumber - Basically just the $_GET variables
     */
    public function __construct()
    {
        $this->getMlsNumber();
        $this->create();
        $this->assembleMedia();
        $this->setListingSeo();
    }

    public function getListingInfo()
    {
        return $this->listingInfo;
    }

    public function getMlsNumber()
    {
        $pathFragments = explode('listing/',$_SERVER['REQUEST_URI']);
        $this->mlsNumber = str_replace('/','',end($pathFragments));
    }

    public function create()
    {
        $client  = new Client(['base_uri' => 'https://rafgc.kerigan.com/api/v1/']);
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
            $title = $this->listingInfo->street_num . ' ' . $this->listingInfo->street_name;
            $title = ($this->listingInfo->unit_num != '' ? $title . ' ' . $this->listingInfo->unit_num : $title);
            $metaTitle = $title . ' | $' . number_format($this->listingInfo->price) . ' | ' . $this->listingInfo->city . ' | ' . get_bloginfo('name');
            return $metaTitle;
        });

        add_filter('wpseo_metadesc', function () {
            return strip_tags($this->listingInfo->remarks);
        });

        add_filter('wpseo_opengraph_image', function () {
            return ($this->media['photos'][0]->url != '' ? $this->media['photos'][0]->url : get_template_directory_uri() . '/img/nophoto.jpg');
        });

        add_filter('wpseo_canonical',  function () {
            return get_the_permalink() . $this->listingInfo->mls_account . '/';
        });

        add_filter('wpseo_opengraph_url', function ($ogUrl) {
            return get_the_permalink() . $this->listingInfo->mls_account . '/';
        }, 100, 1);
    }

    public function assembleMedia()
    {
        $media  = $this->listingInfo->media_objects->data;
        $return = [ 'photos','vtours','docs','files','links'];
    
        foreach($media as $var){
            if($var->media_type == 'Photo'){ $return['photos'][] = $var; } 
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