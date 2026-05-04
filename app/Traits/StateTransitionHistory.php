<?php

namespace App\Traits;

use App\Models\Approval;
use App\Models\ApprovalStatus;

trait StateTransitionHistory
{
    protected function logTransition($user_id, $from_state, $to_state, $transition, $comment = null) {
        $this->training->stateHistory()->create([
            'user_id' => $user_id,
            'from_state' => $from_state,
            'to_state' => $to_state,
            'transition' => $transition,
            'comment' => $comment,
        ]);
    }

}
