<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class MapSearch
{
    protected $approvedParams;
    protected $searchRequested;
    protected $searchParams;
    protected $searchResults;
    protected $formattedRequest;

    /**
     * QuickSearch constructor.
     * configure any options here
     */
    public function __construct ()
    {
        $this->approvedParams = [
            'omni',
            'area',
            'status',
            'propertyType',
            'forclosure',
            'minPrice',
            'maxPrice',
            'beds',
            'baths',
            'sqft',
            'acreage',
            'waterfront',
            'waterview',
            'sort',
            'page'
        ];
        $this->searchParams = [
            'omni'   => '',
            'status' => ['active' => 'Active'],
            'excludes' => 'Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County'
        ];
        $this->searchResults = [];
        $this->searchRequested = (isset($_GET['q']) && $_GET['q'] == 'search' ? $_GET : []);

        //set default if no search performed
        if(!$this->searchRequested){
            $this->searchRequested = [];
        }

        $this->contactTheMothership();
    }

    public function getSearchResults()
    {
        //echo '<pre>',print_r($this->searchResults),'</pre>';
        return $this->searchResults;
    }

    public function getPins()
    {
        return json_encode($this->searchResults->data);
    }

    public function getCurrentRequest()
    {
        return json_encode($this->searchParams);
    }

    public function getSort()
    {
        return isset($this->searchParams['sort']) ? $this->searchParams['sort'] : 'date_modified|desc';
    }

    public function filterRequest()
    {
        foreach($this->searchRequested as $key => $var){
            if(in_array($key, $this->approvedParams)){
                $this->searchParams[$key] = $var;
            }
        }
    }

    //build URL for mothership contact
    public function makeRequest()
    {
        $this->filterRequest();

        $request = '?q=search';
        foreach($this->searchParams as $key => $var){
            if(is_array($var)){
                $request .= '&' . $key . '=';
                $i = 1;
                foreach($var as $k => $v){
                    $request .= $v . ($i < count($var) ? '|' : '');
                    $i++;
                }
            }else{
                if($var != '' && $var != 'Any'){
                    $request .= '&' . $key . '=' . $var;
                }
            }
        }

        return $request;
    }

    public function contactTheMothership()
    {
        $client     = new Client(['base_uri' => 'https://rafgc.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', 'map-search' . $this->makeRequest()
        );

        $this->searchResults = json_decode($apiCall->getBody());
    }
}
