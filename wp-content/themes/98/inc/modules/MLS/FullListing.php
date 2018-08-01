<?php
namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class FullListing
{
    protected $mlsNumber;
    protected $listingInfo;

    /**
     * Search Constructor
     * @param string $mlsNumber - Basically just the $_GET variables
     */
    public function __construct()
    {
        $this->mlsNumber = $this->getMlsNumber();
        $this->create();
        $this->setListingSeo();
    }

    public function getListingInfo()
    {
        return $this->listingInfo;
    }

    public function getMlsNumber()
    {
        $pathFragments = explode('/',$_SERVER['REQUEST_URI']);
        return end(array_filter($pathFragments, function($value) { return $value !== ''; }));
    }

    public function create()
    {
        $client  = new Client(['base_uri' => 'https://rafgc.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', 'listing/' . $this->mlsNumber
        );

        $results = json_decode($raw->getBody());
        $this->listingInfo = $results;

        return $results;
    }

    public function setListingSeo()
    {
        add_filter('wpseo_title', function () {
            $title = $this->listingInfo->street_number . ' ' . $this->listingInfo->street_name .' '. $this->listingInfo->street_suffix;
            $title = ($this->listingInfo->unit_number != '' ? $title . ' ' . $this->listingInfo->unit_number : $title);
            $metaTitle = $title . ' | $' . number_format($this->listingInfo->price) . ' | ' . $this->listingInfo->city . ' | ' . get_bloginfo('name');
            return $metaTitle;
        });

        add_filter('wpseo_metadesc', function () {
            return strip_tags($this->listingInfo->description);
        });

        add_filter('wpseo_opengraph_image', function () {
            return ($this->listingInfo->preferred_image != '' ? $this->listingInfo->preferred_image : get_template_directory_uri() . '/img/beachybeach-placeholder.jpg');
        });

        add_filter('wpseo_canonical',  function () {
            return get_the_permalink() . '?mls=' . $this->listingInfo->mls_account;
        });

        add_filter('wpseo_opengraph_url', function ($ogUrl) {
            return get_the_permalink() . '?mls=' . $this->listingInfo->mls_account;
        }, 100, 1);
    }
}