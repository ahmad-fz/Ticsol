<?php

namespace App\Ticsol\Components\Models;

use App\Ticsol\Components\Models;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $table = 'ts_timesheets';
    protected $primaryKey = 'id';    
    protected $dates = ['deleted_at'];
    protected $appends = ['user', 'approver', 'status', 'canExportToQBs', 'commentsCount'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id',
        'year',
        'week_start',
        'week_end',
        'week_number',
        'total_hours',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeOfClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('creator_id', $userId)
            ->orWhere(function ($query) use ($userId) {
                $query->whereHas('request', function ($query) use ($userId) {
                    $query->where('assigned_id', $userId);
                });
            });
    }

    public function getStatusAttribute()
    {
        return $this->request()->first()->status;
    }

    public function getUserAttribute()
    {
        $creator = $this->creator()->first();
        $user = new \stdClass();
        $user->id = $creator->id;
        $user->fullname = $creator->fullname;
        return $user;
    }

    public function getApproverAttribute()
    {
        $assigned = $this->request()->first()->assigned()->first();
        if ($assigned) {
            $approver = new \stdClass();
            $approver->id = $assigned->id;
            $approver->fullname = $assigned->fullname;
            return $approver;
        } else {
            return null;
        }
    }

    public function getCanExportToQBsAttribute()
    {
        $items = $this->schedules()->get()->all();

        foreach ($items as $item) {
            if ($item->billable && !$item->canExportToQBs) {
                return false;
            }
        }

        return true;
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    #region Eloquent_Relationships

    /**
     * Assosiated client to current timesheet.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Creator of current timesheet.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Assosiated job to current timesheet.
     */
    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    /**
     * Assosiated schedule items to current timesheet.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Assosiated comments items to current timesheet.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    #endregion
}
