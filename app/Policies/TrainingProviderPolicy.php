<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TrainingProvider;

class TrainingProviderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        // dd('TrainingPolicy constructor');
    }

    /**
     * Determine whether the user can update the training.
     */
    public function update(User $user, TrainingProvider $provider): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the training.
     */
    public function delete(User $user, TrainingProvider $provider): bool
    {
        return true;
    }

}
