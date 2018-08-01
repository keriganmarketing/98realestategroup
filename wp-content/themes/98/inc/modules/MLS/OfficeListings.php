<?php

namespace Includes\Modules\MLS;

class OfficeListings extends CuratedResults {

    protected $officeID;

    public function __construct($officeID)
    {
        $this->officeID = $officeID;
        parent::set('endPoint', 'our-properties/' . $this->officeID);
        parent::set('searchParams', [
            'sort'   => $this->getSort(),
            'status' => 'active'
        ]);
    }

}