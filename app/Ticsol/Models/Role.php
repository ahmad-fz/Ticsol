<?php

namespace App\Ticsol\Models;

use Illuminate\Database\Eloquent\Model;
use App\Ticsol\Models;

class Role extends Model
{
    protected $table = 'ts_roles';
    protected $primaryKey = 'role_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_name',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function users()
    {
        $this->belongsToMany(User::class);
    }

    public function ACLs()
    {
        return $this->hasMany(ACL::class);
    }
}
