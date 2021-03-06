<?php

namespace App\Ticsol\Components\Models;

use App\Ticsol\Components\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'ts_teams';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function scopeOfClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }
    

    #region Eloquent_Relationships

    /**
     * Assosiated client to current schedule item.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Creator of current schedule item.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
    /**
     * Assosiated users to this team.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'ts_user_team');
    }

    #endregion
}
