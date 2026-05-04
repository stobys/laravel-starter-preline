<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;
use App\Models\TrainingProvider;

class NotificationPolicy
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
    public function details(User $user, Notification $notification): bool
    {
        return $notification->user_id == $user->id;
    }

    /**
     * Determine whether the user can update the training.
     */
    public function update(User $user, Notification $notification): bool
    {
        return $notification->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the training.
     */
    public function delete(User $user, Notification $notification): bool
    {
        return $notification->user_id == $user->id;
    }

}
