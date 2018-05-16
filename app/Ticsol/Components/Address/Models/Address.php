<?php

namespace App\Ticsol\Components\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Ticsol\Components\Models;

class Address extends Model
{    
    protected $table = 'ts_Addresses';
    protected $primaryKey = 'address_id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'address_id',
        'address_unit',
        'address_street',
        'address_suburb',
        'address_country',
        'address_postcode',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    #region Eloquent_Relationships

    /**
     * Associated contact to current address.
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    #endregion
}