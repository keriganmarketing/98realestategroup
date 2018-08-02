<?php

namespace Includes\Modules\MLS;

class UnderContract extends CuratedResults {

    public function __construct()
    {
        parent::set('endPoint', 'contingent-pending');
        parent::set('searchParams', [
            'sort'   => $this->getSort()
        ]);
    }

}