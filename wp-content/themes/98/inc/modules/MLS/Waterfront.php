<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class Waterfront {

    public function __construct()
    {
    }

    public function contactTheMothership()
    {
        $client  = new Client(['base_uri' => 'https://rafgc.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', 'waterfront'
        );

        $response = json_decode($apiCall->getBody());

        return $response->data;
    }

    public function getListings()
    {
        return $this->contactTheMothership();
    }
}