<?php

namespace App\Ticsol\Components\Job\Repository;

use App\Ticsol\Base\Repository\Repository;
use App\Ticsol\Components\Models\Job;

class JobRepository extends Repository{
    
    public function model()
    {
        return 'App\Ticsol\Components\Models\Job';
    }
}