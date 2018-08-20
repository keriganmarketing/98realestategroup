<?php

namespace Includes\Modules\MLS;

class AreaListings extends CuratedResults {

    public function __construct($area)
    {
        parent::set('endPoint', 'search');
        parent::set('searchParams', [
            'sort'   => $this->getSort(),
            'area'   => $area,
            'excludes' => 'Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County'
        ]);
    }

}