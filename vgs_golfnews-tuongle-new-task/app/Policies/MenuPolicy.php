<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
     
        return $user->isSuperAdmin();
    }

    public function form(User $user)
    {
        return $user->isSuperAdmin() ;
    }

    public function save(User $user)
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user)
    {
        return $user->isSuperAdmin();
    }

    public function updateTree(User $user)
    {
        return $user->isSuperAdmin();
    }
}
