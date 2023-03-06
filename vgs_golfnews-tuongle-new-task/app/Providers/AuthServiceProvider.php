<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Menu;
use App\Models\User;
use App\Policies\BannerPolicy;
use App\Policies\MenuPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Banner::class => BannerPolicy::class,
        Menu::class => MenuPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Category
        Gate::define('category-index', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin']);
        });
        Gate::define('category-form', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin']);
        });
        Gate::define('category-save', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin']);
        });
        Gate::define('category-delete', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin']);
        });
        Gate::define('category-update-tree', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin']);
        });

        // Banner Category
        Gate::define('banners-category-index', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('banners-category-form', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });
        Gate::define('banners-category-save', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });
        Gate::define('banners-category-delete', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });
        Gate::define('banners-category-update-tree', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });

        // Banner Categories
        Gate::define('banners-categories-index', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });
        Gate::define('banners-categories-form', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });
        Gate::define('banners-categories-save', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });
        Gate::define('banners-categories-delete', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });
        Gate::define('banners-categories-update-tree', function (User $user) {
            return in_array($user->level, ['super_admin', 'user_tournament']);
        });
        // Tournament Categories
        Gate::define('tournament-categories-index', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-categories-form', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-categories-save', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-categories-delete', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-categories-update-tree', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        // Tournament live
        Gate::define('tournament-live-index', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-live-form', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-live-save', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-live-delete', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-live-update-tree', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        // Tournament live scheldule
        Gate::define('tournament-live-scheldule-index', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-live-scheldule-form', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-live-scheldule-save', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-live-scheldule-delete', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });
        Gate::define('tournament-live-scheldule-update-tree', function (User $user) {
            return in_array($user->level, ['super_admin','user_tournament']);
        });


        // Post
        Gate::define('post-index', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin', 'user','user_tournament']);
        });
        Gate::define('post-form', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin', 'user','user_tournament']);
        });
        Gate::define('post-save', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin', 'user','user_tournament']);
        });
        Gate::define('post-delete', function (User $user) {
            return in_array($user->level, ['super_admin', 'admin', 'user','user_tournament']);
        });


        // Setting
        Gate::define('setting', function (User $user) {
            return $user->isSuperAdmin();
        });

        // User
        Gate::define('user-index', function (User $user) {
            return $user->isSuperAdmin();
        });
        Gate::define('user-form', function (User $user) {
            return $user->isSuperAdmin();
        });
        Gate::define('user-save', function (User $user) {
            return $user->isSuperAdmin();
        });
        Gate::define('user-delete', function (User $user, $id) {
             return $user->isSuperAdmin() && $user->id != $id;
        });
        Gate::define('user-change-password', function (User $user) {
            return $user->isSuperAdmin();
        });
        Gate::define('user-status', function (User $user, $id) {
             return $user->isSuperAdmin() && $user->id != $id;
        });
    }
}
