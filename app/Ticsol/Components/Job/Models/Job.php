<?php

namespace App\Ticsol\Components\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Ticsol\Components\Models;

class Job extends Model
{    
    protected $table = 'ts_jobs';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [        
        'parent_id',
        'form_id',
        'title',
        'code',
        'isactive', 
        'meta',       
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'client_id',
        'creator_id',        
    ];

    public function scopeOfClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }


    #region Eloquent_Relationships

    /**
     * Assosiated client to current job.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Creator of current job.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Assosiated requests to current job.
     */
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    /**
     * Assosiated schedules to current job.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Parent of current job.
     */
    public function parent()
    {
        return $this->belongsTo(Job::class, 'parent_id');
    }

    /**
     * Childs of current job.
     */
    public function childs()
    {
        return $this->hasMany(Job::class, 'parent_id');
    }

    /**
     * Assosiated profile to current job.
     */
    public function profile()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    /**
     * Assosiated contacts to current job.
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'ts_job_contact', 'job_id', 'contact_id')
            ->withPivot('type')->withTimestamps();
    }

    /**
     * Activities of current job.
     */
    public function Activities()
    {
        return $this->hasMany(Activity::class);
    }

    #regionend
}