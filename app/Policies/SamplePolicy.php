<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Training;
use App\Models\User;
use Illuminate\Auth\Access\Response;

final readonly class SamplePolicy
{
    /**
     * Determine if the given post can be updated by the user.
     */
    public function update(User $user, Training $training): Response
    {
        return $user->id === $training->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
