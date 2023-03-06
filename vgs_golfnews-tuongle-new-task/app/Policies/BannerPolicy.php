<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return in_array($user->level, ['super_admin', 'admin', 'user', 'user_ads','user_tournament']);
    }

    public function form(User $user)
    {
        return in_array($user->level, ['super_admin', 'admin', 'user', 'user_ads','user_tournament']);
    }

    public function save(User $user)
    {
        return in_array($user->level, ['super_admin', 'admin', 'user', 'user_ads','user_tournament']);
    }

    public function delete(User $user)
    {
        return in_array($user->level, ['super_admin', 'admin', 'user', 'user_ads','user_tournament']);
    }
}
