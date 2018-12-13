<?php

namespace App\Ticsol\Base\Policies;

use App\Request;
use App\Ticsol\Components\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list of requests.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Request  $request
     * @return mixed
     */
    function list(User $user) {
        return true;
    }

    /**
     * Determine whether the user can view the list of all requests.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Request  $request
     * @return mixed
     */
    public function listAll(User $user)
    {
        $roles = $user->load('roles.permissions')->roles;
        foreach ($roles as $role) {
            if ($role->permissions->contains('name', 'list_all-request')) {
                return true;
            }
        }
    }

    /**
     * Determine whether the user can view the request.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Request  $request
     * @return mixed
     */
    public function view(User $user, Request $request)
    {
        if ($request->user_id === $user->id || $request->assigned_id === $user->id) {
            return true;
        } else {
            $roles = $user->load('roles.permissions')->roles;
            foreach ($roles as $role) {
                if ($role->permissions->contains('name', 'view_all-request')) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * Determine whether the user can create requests.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the request.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Request  $request
     * @return mixed
     */
    public function update(User $user, Request $request)
    {
        if ($request->client_id !== $user->client_id) {
            return false;
        }

        if ($request->status === 'approved' || $request->status === 'rejected') {
            return false;
        }

        return $request->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the request.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Request  $request
     * @return mixed
     */
    public function delete(User $user, Request $request)
    {
        //
    }

    /**
     * Determine whether the user can approve the request.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Request  $request
     * @return mixed
     */
    public function approve(User $user, Request $request)
    {
        $canApproveLeave = false;
        $canApproveTimesheet = false;
        $canApproveReimbursement = false;

        if ($request->client_id !== $user->client_id) {
            return false;
        }

        if ($request->status === 'approved' || $request->status === 'rejected') {
            return false;
        }

        $roles = $user->load('roles.permissions')->roles;
        foreach ($roles as $role) {
            if ($role->permissions->contains('name', 'approve-leave')) {
                $canApproveLeave = true;
            }
            if ($role->permissions->contains('name', 'approve-timesheet')) {
                $canApproveTimesheet = true;
            }
            if ($role->permissions->contains('name', 'approve-reimbursement')) {
                $canApproveReimbursement = true;
            }
        }

        if ($request->type === 'leave' && $canApproveLeave) {
            return true;
        }

        if ($request->type === 'timesheet' && $canApproveTimesheet) {
            return true;
        }

        if ($request->type === 'reimbursement' && $canApproveReimbursement) {
            return true;
        }

    }
}
