<?php

namespace App\Policies;

use App\Domain\Application\Model\Application;
use App\Domain\Authorization\Model\Authorization;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  Authorization  $authorization
     * @return mixed
     */
    public function viewAny(Authorization $authorization)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Authorization  $authorization
     * @param  Application  $application
     * @return mixed
     */
    public function view(Authorization $authorization, Application $application)
    {
        if (!$authorization->token) {
            return true;
        }

        return $authorization->applications->filter(function ($app) use ($application) {
            return $app->id === $application->id;
        })->count() > 0;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Domain\User\Model\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Domain\User\Model\User  $user
     * @param  \App\Models\Authorization  $authorization
     * @return mixed
     */
    public function update(User $user, Authorization $authorization)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Domain\User\Model\User  $user
     * @param  \App\Models\Authorization  $authorization
     * @return mixed
     */
    public function delete(User $user, Authorization $authorization)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Domain\User\Model\User  $user
     * @param  \App\Models\Authorization  $authorization
     * @return mixed
     */
    public function restore(User $user, Authorization $authorization)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Domain\User\Model\User  $user
     * @param  \App\Models\Authorization  $authorization
     * @return mixed
     */
    public function forceDelete(User $user, Authorization $authorization)
    {
        //
    }
}
