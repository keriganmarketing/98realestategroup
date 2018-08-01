<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class AgentListings {

    protected $agentID;

    public function __construct($agentID)
    {
        $this->agentID = $agentID;
    }

    public function contactTheMothership()
    {
        $client  = new Client(['base_uri' => 'https://rafgc.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', 'agent-listings/' . $this->agentID
        );

        $response = json_decode($apiCall->getBody());

        return $response->data;
    }

    public function getListings()
    {
        $allListings    = ($this->agentID != '' ? $this->contactTheMothership() : []);
        $activeListings = [];
        $soldListings   = [];

        // echo '<pre>',print_r($allListings ),'</pre>';

        if(is_array($allListings)){
            array_map(function($listing) use (&$activeListings, &$soldListings){
                if($listing->status == 'Active' || $listing->status == 'Contingent' || $listing->status == 'Pending'){ 
                    array_push($activeListings, $listing); 
                }else{
                    if(date('Ymd', strtotime($listing->sold_on)) >= date('Ymd', strtotime('-6 months'))){
                        array_push($soldListings, $listing);
                    } 
                }  
            }, $allListings);
        }

        return [
            'active' => $activeListings,
            'sold'   => $soldListings
        ];
    }

}