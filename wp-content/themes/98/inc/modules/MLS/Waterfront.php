<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class Waterfront extends CuratedResults {

    public function __construct()
    {
        parent::set('endPoint', 'waterfront');
        parent::set('searchParams', [
            'sort'   => $this->getSort(),
            'excludes' => 'Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County'
        ]);
    }

}