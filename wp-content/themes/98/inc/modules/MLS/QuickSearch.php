<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class QuickSearch
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
            'sort' => 'date_modified|desc',
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
        return $this->searchResults;
    }

    public function getResultMeta()
    {
        return isset($this->searchResults->meta->pagination) ? $this->searchResults->meta->pagination : null;
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

        $request = $request . '&page=' . get_query_var( 'page' ) . '&excludes=St. George Island|Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County';
        echo $request;
        
        return $request;
    }

    public function contactTheMothership()
    {
        $client     = new Client(['base_uri' => 'https://navica.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', 'search' . $this->makeRequest()
        );

        $this->searchResults = json_decode($apiCall->getBody());
    }

    public function buildPagination()
    {
        $pagination = new SearchPagination($this->getResultMeta(),$this->searchParams);
        $pagination->buildPagination();
    }
}
