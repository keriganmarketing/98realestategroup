<?php

namespace Includes\Modules\MLS;

class OfficeSolds extends CuratedResults {

    protected $officeID;

    public function __construct($officeID)
    {
        $this->officeID = $officeID;
        parent::set('endPoint', 'our-recently-sold/' . $this->officeID);
        parent::set('searchParams', [
            'sort'     => $this->getSort(),
            'status'   => ['sold' => 'Sold'],
            'excludes' => 'Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County'
        ]);
    }

}