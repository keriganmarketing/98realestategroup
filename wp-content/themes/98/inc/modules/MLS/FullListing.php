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

    /**
     * Checks whether Yoast is active
     * Returns Boolean
     */
    protected function yoastActive()
    {
        $active_plugins = get_option('active_plugins');
        foreach($active_plugins as $plugin){
            if(strpos($plugin, 'wp-seo')){
                return true;
            }
        }
        return false;
    }

    /**
     * Hook meta tags into WP lifecycle
     * Removes Yoast tags since they don't work well in this use case.
     */
    public function setListingSeo()
    {
        // override Yoast so we can use dynamic data
        if($this->yoastActive()){
            add_filter('wpseo_title', [$this, 'seoTitle']);
            add_filter('wpseo_metadesc', function () { return false; });
            add_filter('wpseo_canonical', function () { return false; });
            add_filter('wpseo_robots', function () { return false; });
            add_filter('wpseo_opengraph_url', function () { return false; });
            add_filter('wpseo_opengraph_type', function () { return false; });
            add_filter('wpseo_opengraph_image', function () { return false; });
            add_filter('wpseo_opengraph_title', function () { return false; });
            add_filter('wpseo_opengraph_site_name', function () { return false; });
            add_filter('wpseo_opengraph_admin', function () { return false; });
            add_filter('wpseo_opengraph_author_facebook', function () { return false; });
            add_filter('wpseo_opengraph_show_publish_date', function () { return false; });
            add_filter('wpseo_twitter_description', function () { return false; });
            add_filter('wpseo_twitter_card_type', function () { return false; });
            add_filter('wpseo_twitter_site', function () { return false; });
            add_filter('wpseo_twitter_image', function () { return false; });
            add_filter('wpseo_twitter_creator_account', function () { return false; });
            add_filter('wpseo_json_ld_output', function () { return false; });
        }

        add_filter('pre_get_document_title', [$this, 'seoTitle']);
        add_action( 'wp_head', [$this, 'setStandardMeta']);
        add_action( 'wp_head', [$this, 'setTwitterCard']);
        add_action( 'wp_head', [$this, 'setOpenGraph']);
    }

    /**
     * Publishes standard meta description and canonical tags
     * Echos output directly
     */
    public function setStandardMeta()
    {
        echo '<meta name="description" content="'.$this->metaDescription().'" />';
        echo '<link rel="canonical" href="'.$this->canonicalUrl().'"/>';
    }

    /**
     * Publishes twitter meta tags for nice looking twitter cards
     * Echos output directly
     */
    public function setTwitterCard()
    {
        echo '<meta name="twitter:title" content="'.$this->seoTitle().'" />';
        echo '<meta name="twitter:card" content="summary_large_image" />';
        echo '<meta name="description" content="'.$this->metaDescription().'"/>';
        echo '<meta name="twitter:site" content="'.get_bloginfo('name').'"/>';
    }

    /**
     * Publishes Open Graph tags for nice looking Facebook snippets
     * Echos output directly
     */
    public function setOpenGraph()
    {
        echo '<meta property="og:site_name" content="'.get_bloginfo('name').'" />';
        echo '<meta name="og:title" content="'.$this->seoTitle().'" />';
        echo '<meta name="og:description" content="'.$this->metaDescription().'" />';
        echo '<meta property="og:url" content="'.$this->canonicalUrl().'" />';
        echo '<meta property="og:type" content="'.$this->ogType().'"/>';
        echo '<meta property="og:street-address" content="'.$this->listingInfo->data->full_address.'"/>'; 
        echo '<meta property="og:locality" content="'.$this->listingInfo->data->city.'"/>'; 
        echo '<meta property="og:region" content="'.$this->listingInfo->data->state.'"/>'; 
        echo '<meta property="og:postal-code" content="'.$this->listingInfo->data->zip.'"/>'; 
        echo '<meta property="og:country-name" content="USA"/>'; 
        echo '<meta property="place:location:latitude" content="'.$this->listingInfo->data->location->lat.'"/>'; 
        echo '<meta property="place:location:longitude" content="'.$this->listingInfo->data->location->long.'"/>';

        $this->ogImage();
    }

    /**
     * Breaks down the primary image from the mothership and pops out the url, height and width required for Facebook
     * Echos output directly
     */
    public function ogImage($url = null)
    {
        $photoParts = getimagesize ( $this->listingInfo->data->media_objects->data[0]->url );
        echo '<meta property="og:image" content="' .  $this->listingInfo->data->media_objects->data[0]->url . '" />' . "\n";
        echo '<meta property="og:image:secure_url" content="' .  str_replace('http://','https://', $this->listingInfo->data->media_objects->data[0]->url ) . '" />' . "\n";
        echo '<meta property="og:image:width" content="' .  $photoParts['0'] . '" />' . "\n";
        echo '<meta property="og:image:height" content="' .  $photoParts['1'] . '" />' . "\n";
    }

    /**
     * Sets the schema type to place. This may change in the future, but for now it's what Realtor.com uses.
     * @return String
     */
    public function ogType($type = null)
    {
        return "place";
    }

    /**
     * Returns the correct canonical URL
     * @return String
     */
    public function canonicalUrl($data = null)
    {
        return trailingslashit($_SERVER["REQUEST_URI"]);
    }

    /**
     * Returns a formatted page title with listing data
     * @return String $title
     */
    public function seoTitle($data = null)
    {
        $title = $this->listingInfo->data->street_num . ' ' . $this->listingInfo->data->street_name;
        $title = ($this->listingInfo->data->unit_num != '' ? $title . ' ' . $this->listingInfo->data->unit_num : $title);
        $metaTitle = $title . ' | $' . number_format($this->listingInfo->data->price) . ' | ' . $this->listingInfo->data->city . ' | ' . get_bloginfo('name');
        return $metaTitle;

        return $title;
    }

    /**
     * Returns a truncated meta description
     * @return String $text
     */
    public function metaDescription()
    {
        $metaLength = 130;
        $break = ' ';
        $pad = '...';
        $text = $this->listingInfo->data->remarks;

        if($metaLength < strlen($text) && ($breakpoint = strpos($text, $break, $metaLength) !== false)) { 
            if($breakpoint < strlen($text) - 1) { 
                $text = substr($text, 0, $breakpoint) . $pad; 
            } 
        } 

        return $text;
    }

    /**
     * Returns a simplified string based on what property type is returned from the listing data. We do this for our SEO content. 
     * @return String $type
     */
    public function fixType()
    {
        $type = $this->listingInfo->data->prop_type;

        //Change just the ones that need to be changed
        switch ($type) {
            case 'Residential Lots/Land':
                $type = 'Land';
                break;
            case 'Improved Commercial':
                $type = 'Commercial property';
                break;
            case 'Real Estate & Business':
                $type = 'Property';
                break;
            case 'Unimproved Land':
                $type = 'Land';
                break;
            case 'Dup/Tri/Quad (Multi-Unit)':
                $type = 'Multi-Unit Property';
                break;
            case 'Detached Single Family':
                $type = 'House';
                break;
            case 'Mobile/Manufactured':
                $type = 'Mobile Home';
                break;
            case 'ASF (Attached Single Family)':
                $type = 'Townhome';
                break;
            case 'Apartments/Multi-Family':
                $type = 'Apartment';
                break;
            case 'Condominium':
                $type = 'Condo';
                break;
            case 'Condominium Rental':
                $type = 'Condo';
                break;
            case 'ASF (Attached Single Family) Rental':
                $type = 'Townhome';
                break;
            case 'Detached Single Family Rental':
                $type = 'House';
                break;
        }
        
        return $type;
    }    
}