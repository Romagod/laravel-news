<?php

namespace App\Policies;

use App\Eloquent\Posts;
use App\Eloquent\Roles;
use App\Eloquent\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if user can be create post.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user)
    {
        $role = Roles::where('name', 'admin')->first();

        return intval($user->role_id) === intval($role->id);
    }
}
