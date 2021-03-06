<?php

namespace App\Ticsol\Base\Policies;

use App\Ticsol\Components\Models\Contact;
use App\Ticsol\Components\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        //
    }

    /**
     * Determine whether the user can view the list of jobs.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @return mixed
     */
    function list(User $user) {
        return true;
    }

    /**
     * Determine whether the user can view the contact.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Ticsol\Components\Models\Contact  $contact
     * @return mixed
     */
    public function view(User $user, Contact $contact)
    {
        return $user->client_id == $contact->client_id;
    }

    /**
     * Determine whether the user can create contacts.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the contact.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Ticsol\Components\Models\Contact  $contact
     * @return mixed
     */
    public function update(User $user, Contact $contact)
    {
        if ($contact->client_id !== $user->client_id) {
            return false;
        }

        if ($contact->group == 'customer') {
            return true;
        } else {
            return $contact->user_id == $user->id;
        }

    }

    /**
     * Determine whether the user can delete the contact.
     *
     * @param  \App\Ticsol\Components\Models\User  $user
     * @param  \App\Ticsol\Components\Models\Contact  $contact
     * @return mixed
     */
    public function delete(User $user, Contact $contact)
    {
        if ($contact->client_id !== $user->client_id) {
            return false;
        }

        if ($contact->group == 'customer') {
            return true;
        } else {
            return $contact->user_id == $user->id;
        }
    }
}
