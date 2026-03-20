<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
class AdminSettingsPolicy
{
    use HandlesAuthorization;

     /**
     * Determine whether the user can view any models.
     */
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
}
