<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class NewListings extends CuratedResults {

    public function __construct()
    {
        parent::set('endPoint', 'new-listings');
        parent::set('searchParams', [
            'sort'   => $this->getSort(),
            'excludes' => 'Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County'
        ]);
    }

}