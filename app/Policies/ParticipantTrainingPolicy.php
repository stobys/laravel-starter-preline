<?php

namespace App\Policies;

use App\Models\Pivots\ParticipantTraining;
use App\Models\User;
use Illuminate\Support\Carbon;

class ParticipantTrainingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function managerRejection(User $user, ParticipantTraining $pivot): bool
    {
		// Ta sama logika jak approve
        return $this->managerApproval($user, $pivot);
    }

    public function managerApproval(User $user, ParticipantTraining $pivot): bool
    {
        // -- olny planned can be send for approval
        if( ! $pivot->training->state->isPending() ) {
            return false;
        }

		// -- if already decided
		if($pivot->undecided())
		{
			return false;
		}

        // -- olny if authenticated user is manager of department of participant
        if( $user->id !== $pivot->participant->department->manager_id ) {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

    public function review(User $user, ParticipantTraining $pivot): bool
    {
        // -- olny planned can be send for approval
        if( ! $pivot->training->state->isCompleted() )
		{
            return false;
        }

		// -- review doesn't belong to user
		if( $pivot->participant_id !== $user->id )
		{
            return false;
        }

		// -- participation is rejected
		if( $pivot->rejected_at )
		{
            return false;
        }

		// -- review not owned by use
		if( $pivot->reviewer_id !== $user->id )
		{
			return false;
		}

		// -- already reviewed
		if( $pivot->submitted_at )
		{
			return false;
		}


		// -- other checks, permissions for instance
		return true;
    }

    public function evaluate(User $user, ParticipantTraining $pivot): bool
    {
        // -- training isn't in reviewed state
        if( ! $pivot->training->state->isReviewed() ) {
            return false;
        }

        // -- authenticated isn't participant's manager (participants departments manager to be precise)
        if( $user->id !== $pivot->participant->department->manager_id ) {
            return false;
        }

        // -- there is no evaluation ready for that participant yet
		if( $pivot->training->evaluations()->whereParticipantId($pivot->participant_id)->doesntExist() )
		{
            return false;
		}

		// -- evaluation exists, but not yet available for submition
		if( $pivot->training->evaluations()->whereParticipantId($pivot->participant_id)->first()->available_at > Carbon::now() )
        {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

    public function markNoShow(User $user, ParticipantTraining $pivot): bool
    {
        // -- participant is either rejected or not dicided yet
        if( $pivot->rejected() || (! $pivot->rejected() && ! $pivot->approved()) ) {
            return false;
        }

		// -- other checks, permissions for instance
		return true;
    }

}
