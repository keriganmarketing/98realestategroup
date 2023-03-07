<?php

namespace Includes\Modules\MLS;

class NewOfficeListings extends CuratedResults {

    protected $officeID;

    public function __construct($officeID)
    {
        $this->officeID = $officeID;
        parent::set('endPoint', 'our-properties/' . $this->officeID);
        parent::set('searchParams', [
            'sort'   => $this->getSort(),
            'status' => ['active' => 'Active'],
            'excludes' => 'Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County'
        ]);
    }

}