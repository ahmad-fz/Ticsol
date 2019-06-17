<?php

namespace App\Ticsol\Base\Policies;

use App\Ticsol\Components\Models\Timesheet;
use App\Ticsol\Components\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimesheetPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        //
    }

    /**
     * Determine whether the user can view the list of schedule.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @return mixed
     */
    function list(User $user) {
        return true;
    }

    /**
     * Determine whether the user can view the timesheet.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Ticsol\Components\Models\Timesheet  $timesheet
     * @return mixed
     */
    public function view(User $user, Timesheet $timesheet)
    {
        if ($timesheet->client_id != $user->client_id) {
            return false;
        }

        return $user->id == $timesheet->creator_id || $user->id == $timesheet->request->assigned_id;
    }

    /**
     * Determine whether the user can create timesheets.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the timesheet.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Ticsol\Components\Models\Timesheet  $timesheet
     * @return mixed
     */
    public function update(User $user, Timesheet $timesheet)
    {
        if ($timesheet->client_id != $user->client_id) {
            return false;
        }

        if ($timesheet->request->status == 'approved') {
            return false;
        }

        return $user->id == $timesheet->creator_id;
    }

    /**
     * Determine whether the user can delete the timesheet.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Ticsol\Components\Models\Timesheet  $timesheet
     * @return mixed
     */
    public function delete(User $user, Timesheet $timesheet)
    {
        return false;
    }
}
