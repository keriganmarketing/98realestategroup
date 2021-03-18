<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;
use stdClass;

class CuratedResults {

    protected $approvedParams;
    protected $endPoint;
    protected $searchParams;
    protected $searchResults;
    protected $searchRequested;

    public function __construct()
    {
        $this->searchResults   = new stdClass;
        $this->searchParams    = [
            'omni'   => '',
            'sort' => 'date_modified|desc',
        ];
    }

    protected function set($var, $value)
    {
        $this->$var = $value;
    }

    public function setParams()
    {
        if(isset($_GET['q'])){
            foreach($_GET as $key => $var){
                if($key != 'q' && $key != 'pg'){
                    $this->searchParams[$key] = $var;
                }
                if($key == 'pg'){
                    $this->searchParams['page'] = $var;
                }
            }
        }
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
        return isset($_GET['sort']) ? urldecode($_GET['sort']) : 'date_modified|desc';
    }

    public function filterRequest()
    {
        foreach($this->searchRequested as $key => $var){
            if(in_array($key, $this->approvedParams)){
                $this->searchParams[$key] = $var;
            }
            if($key == 'pg'){
                $this->searchParams['page'] = $var;
            }
        }
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

        return $request . '&excludes=St. George Island|Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County';
    }

    public function contactTheMothership()
    {
        $client  = new Client(['base_uri' => 'https://navica.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', $this->endPoint . $this->makeRequest()
        );

        $this->searchResults = json_decode($apiCall->getBody());
    }

    public function getListings()
    {
        $this->setParams();
        $this->contactTheMothership();
        return $this->searchResults;
    }

    public function buildPagination()
    {
        $pagination = new SearchPagination($this->getResultMeta(),$this->searchParams);
        return $pagination->buildPagination();
    }
}