<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class CuratedResults {

    protected $endPoint;
    protected $searchParams;
    protected $searchResults;
    protected $searchRequested;

    public function __construct()
    {
        $this->searchResults   = [];
        $this->searchParams    = [
            'sort' => $this->getSort()
        ];

        $this->searchRequested = $_GET;

        echo '<pre>',print_r($this->searchParams),'</pre>';
    }

    protected function set($var, $value)
    {
        $this->$var = $value;
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
        return isset($this->searchRequested['sort']) ? $this->searchRequested['sort'] : 'date_modified|desc';
    }

    public function makeRequest()
    {
        $request = '?q=search';
        if(is_array($this->searchParams)){
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
        }

        return $request . '&page=' . get_query_var( 'page' );
    }

    public function contactTheMothership()
    {
        $client  = new Client(['base_uri' => 'https://rafgc.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', $this->endPoint . $this->makeRequest()
        );

        $this->searchResults = json_decode($apiCall->getBody());
    }

    public function getListings()
    {
        $this->contactTheMothership();
        return $this->searchResults;
    }

    public function buildPagination()
    {
        $pagination = new SearchPagination($this->getResultMeta(),$this->searchParams);
        $pagination->buildPagination();
    }
}