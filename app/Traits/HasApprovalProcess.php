<?php

namespace App\Traits;

use App\Models\Approval;
use App\Models\ApprovalStatus;

trait HasApprovalProcess
{
    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable')
            ->orderBy('created_at', 'desc');
    }

    public function approvalStatus()
    {
        return $this->morphOne(ApprovalStatus::class, 'approvable')
            ->latestOfMany();
    }

    public function currentApprovalStep()
    {
        return $this->approvalStatus?->currentStep;
    }

    public function submit()
    {
        $flow = $this->getApprovalFlow();
        $firstStep = $flow->steps()->orderBy('step_order')->first();

        ApprovalStatus::create([
            'approvable_type' => get_class($this),
            'approvable_id' => $this->id,
            'current_step_id' => $firstStep->id,
            'overall_status' => 'in_progress',
            'submitted_at' => now(),
        ]);

        Approval::create([
            'approvable_type' => get_class($this),
            'approvable_id' => $this->id,
            'approval_flow_step_id' => $firstStep->id,
            'status' => 'pending',
        ]);

        // Event/Notification
        event(new \App\Events\ApprovalSubmitted($this, $firstStep));
    }

    public function canBeApprovedBy(User $user): bool
    {
        $currentStep = $this->currentApprovalStep();

        if (!$currentStep) {
            return false;
        }

        // Sprawdź czy user ma odpowiednią rolę
        return $user->hasRole($currentStep->role_name);
    }
}
