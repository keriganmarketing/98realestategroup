<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class SoldListings extends CuratedResults {

    public function __construct()
    {
        parent::set('endPoint', 'recently-sold');
    }

}