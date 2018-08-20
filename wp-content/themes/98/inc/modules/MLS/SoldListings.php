<?php

namespace Includes\Modules\MLS;

class SoldListings extends CuratedResults {

    public function __construct($days)
    {
        parent::set('endPoint', 'recently-sold');
        parent::set('searchParams', [
            'days'   => $days,
            'sort'   => $this->getSort(),
            'excludes' => 'Carrabelle|Apalachicola|Eastpoint|Other Counties|Jackson County|Calhoun County|Holmes County|Washington County'
        ]);
    }

}