<?php

namespace Includes\Modules\MLS;

class Foreclosures extends CuratedResults {

    public function __construct()
    {
        parent::set('endPoint', 'forclosures');
        parent::set('searchParams', [
            'sort'   => $this->getSort()
        ]);
    }

}