<?php

namespace App\Ticsol\Components\Comment\Repository;

use App\Ticsol\Base\Repository\Repository;
use App\Ticsol\Components\Models\Comment;

class CommentRepository extends Repository{
    
    public function model()
    {
        return 'App\Ticsol\Components\Models\Comment';
    }
}