<?php

namespace Includes\Modules\MLS;

class Foreclosures extends CuratedResults {

    public function __construct()
    {
        parent::set('endPoint', 'forclosures');
        parent::set('searchParams', [
            'status' => ['active' => 'Active'],
            'sort'     => $this->getSort(),
            'excludes' => 'Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County'
        ]);
    }

}