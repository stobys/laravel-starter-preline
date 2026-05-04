<?php

namespace App\Policies;

use App\Models\Pivots\ParticipantTraining;
use App\Models\Training;
use App\Models\User;

use App\States\Trainings\FullyApproved;
use App\States\Trainings\Withdrawn;
use App\States\Trainings\Completed;
use App\States\Trainings\Rejected;
use App\States\Trainings\Draft;

class TrainingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    /**
     * Determine whether the user can update the training.
     */
    public function create(User $user): bool
    {
        // -- menadżer i HR może tworzyć szkolenia
        if( $user->isDepartmentManager() || $user->isHRRepresentative() )
        {
            return true;
        }

        // -- reszta nie
        return false;
    }

    /**
     * Determine whether the user can update the training.
     */
    public function update(User $user, Training $training): bool
    {
        if($user->isHRRepresentative())
        {
            return true;
        }

        // -- Można edytować tylko szkolenie pracowników/podwładnych
        return $user->id === $training->user?->department?->manager_id;
    }

    /**
     * Determine whether the user can delete the training.
     */
    public function delete(User $user, Training $training): bool
    {
        // Na przykład tylko właściciel może usunąć draft
        return $user->id === $training->user_id &&
               $training->status === 'draft';
    }

    /**
     * Determine whether the user can reject the training.
     */
    public function details(User $user, Training $training): bool
    {
        return true;

    }

    /**
     * Determine whether the user can submit training for approval.
     */
    public function withdraw(User $user, Training $training): bool
    {
        // FALSE if Withdrawn or Fully Approved
        if( in_array($training->state,[Withdrawn::class, FullyApproved::class]) )
        {
            return false;
        }

        // ONLY if training belongs to users
        return $user->id === $training->user?->department?->manager_id;
    }

    public function submitForApproval(User $user, Training $training): bool
    {
        // -- olny planned can be send for approval
        if( ! $training->state->isPlanned() ) {
            return false;
        }

        // -- olny training with participants can be send for approval
        if( ! $training->participants()->exists() ) {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

    public function pendingWithdrawal(User $user, Training $training): bool
    {
        // -- olny planned can be send for approval
        if( ! $training->state->isPending() ) {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

    // public function managerRejection(User $user, Training $training): bool
    // {
	// 	// Ta sama logika jak approve
    //     return $this->managerApproval($user, $training);
    // }

    // public function managerApproval(User $user, ParticipantTraining $pivot): bool
    // {
    //     // -- olny planned can be send for approval
    //     if( ! $pivot->training->state->isPending() ) {
    //         return false;
    //     }

    //     // -- olny if authenticated user is manager of department of participant
    //     if( $user->id !== $pivot->participant->department->manager_id ) {
    //         return false;
    //     }

	// 	// -- other checks, permissions for instance
	// 	return true;
    // }

    public function rejectedWithdrawal(User $user, Training $training): bool
    {
        // -- olny planned can be send for approval
        if( ! $training->state->isRejected() ) {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

    public function approvedWithdrawal(User $user, Training $training): bool
    {
        // -- olny planned can be send for approval
        if( ! $training->state->isApproved() ) {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

    public function lackOfCompletion(User $user, Training $training): bool
    {
        // -- olny planned can be send for approval
        if( ! $training->state->isApproved() ) {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

    public function completion(User $user, Training $training): bool
    {
        // -- olny planned can be send for approval
        if( ! $training->state->isApproved() ) {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

    public function review(User $user, Training $training): bool
    {
        // -- olny planned can be send for approval
        if( ! $training->state->isCompleted() )
		{
            return false;
        }

		// -- user is not a training participant
		if( !$training->authenticatedUserReviews()->exists() )
		{
			return false;
		}

		// -- user has submitted review already
		if($training->authenticatedUserSubmittedReviews()->exists())
		{
			return false;
		}

		// -- other checks, permissions for instance
		return true;

        // // -- ONLY if training belongs to users
        // return $user->id === $training->user?->department?->manager_id;
    }

	public function flash(User $user, Training $training) {
        return true;
	}

	// 	return $training->evaluations()->exists();
	// }

    // public function markAsRealized(User $user, Training $training): bool
    // {
    //     return true;

    //     // -- forbidden if status other than planned
    //     if(!$training->isStatusPlanned()) {
    //         return false;
    //     }

    //     // -- ONLY if user is owner, or manager of the owner
    //     return in_array($user->id, [$training->user_id, $training->user->manager_id]);
    // }

    // public function markAsEvaluated(User $user, Training $training): bool
    // {
    //     return true;

    //     // -- forbidden if status other than planned
    //     if(!$training->isStatusRealized()) {
    //         return false;
    //     }

    //     // -- ONLY if user is owner
    //     return $user->id === $training->user_id;
    // }

    // public function trainingEvaluate(User $user, Training $training): bool
    // {
    //     return true;

    //     // -- forbidden if status other than planned
    //     if(!$training->isStatusRealized()) {
    //         return false;
    //     }

    //     // -- ONLY if user is owner
    //     return $user->id === $training->user_id;
    // }

    // public function effectivenessEvaluate(User $user, Training $training): bool
    // {
    //     return true;

    //     // -- forbidden if status other than evaluated
    //     if(!$training->isStatusEvaluated()) {
    //         return false;
    //     }

    //     // -- ONLY if user is user's manager
    //     return $user->id === $training->user->department->manager_id;
    // }

    public function import(User $user): bool
    {
        return $user->canAny(['rbac:hr-representative', 'rbac:hr-manager']);
    }

}
