<?php

namespace Includes\Modules\MLS;

class SoldListings extends CuratedResults {

    public function __construct()
    {
        parent::set('endPoint', 'recently-sold');
        parent::set('searchParams', [
            'sort'   => $this->getSort()
        ]);
    }

}