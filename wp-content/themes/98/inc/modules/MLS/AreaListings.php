<?php

namespace Includes\Modules\MLS;

class AreaListings extends CuratedResults {

    public function __construct($area)
    {
        parent::set('endPoint', 'search');
        parent::set('searchParams', [
            'sort'   => $this->getSort(),
            'area'   => $area
        ]);
    }

}