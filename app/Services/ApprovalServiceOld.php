<?php

namespace App\Services;

use App\Models\Training;
use App\Models\Approval;
use App\Models\ApprovalFlow;
use App\Models\ApprovalFlowStep;
use App\Models\TrainingApproval;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// use App\Events\ApprovalApproved;
// use App\Events\ApprovalRejected;
// use App\Events\ApprovalReturned;

class ApprovalServiceOld
{
    public function startApproval(Training $training)
    {
        // Tutaj można dodać logikę wyboru odpowiedniego approval flow,
        // np. na podstawie typu szkolenia, kwoty itp.
        $approvalFlow = $this->getApprovalFlowForTraining($training);
        if (!$approvalFlow) {
            throw new \Exception('No approval flow defined for this training');
        }

        $training->status = $this->mapStepToStatusByOrder(1);
        $training->save();

        // Przypisz approval flow do szkolenia (jeśli masz takie pole)
        // $training->approval_flow_id = $approvalFlow->id;
        // $training->current_step = 1;
        // $training->save();

        return $this->getCurrentApprovers($training, $approvalFlow, 1);
    }

    public function getCurrentApprovers(Training $training, ApprovalFlow $flow = null, int $stepOrder = null)
    {
        if (!$flow) {
            $flow = $this->getApprovalFlowForTraining($training);
        }
        if (!$stepOrder) {
            $stepOrder = 1; // lub wyciągnij z $training->current_step
        }

        $step = ApprovalFlowStep::where('approval_flow_id', $flow->id)
            ->where('step_order', $stepOrder)
            ->first();

        if (!$step) {
            return collect();
        }

        switch ($step->approver_type) {
            case 'role':
                return User::whereHas('roles', function ($query) use ($step) {
                    $query->where('name', $step->approver_identifier);
                })->get();

            case 'user':
                $user = User::find($step->approver_identifier);
                return $user ? collect([$user]) : collect();

            case 'department':
                // Implementacja zależy od struktury firmy i departamentów
                // Można zwrócić użytkowników przypisanych do departamentu
                return collect(); // tymczasowo pusty zwrot
            default:
                return collect();
        }
    }

    public function approve(Training $training, User $user, ?string $comment = null)
    {
        DB::transaction(function () use ($training, $user, $comment) {
            $this->saveApprovalRecord($training, $user, 'approved', $comment);
            $this->moveToNextStep($training);
        });
    }

    public function reject(Training $training, User $user, string $reason)
    {
        DB::transaction(function () use ($training, $user, $reason) {
            $this->saveApprovalRecord($training, $user, 'rejected', $reason);

            $training->status = 'rejected';
            $training->rejection_reason = $reason;
            $training->save();
        });
    }

    protected function moveToNextStep(Training $training)
    {
        $currentStepOrder = $this->getCurrentStepOrder($training);
        $approvalFlow = $this->getApprovalFlowForTraining($training);

        $nextStepOrder = $currentStepOrder + 1;

        $nextStep = ApprovalFlowStep::where('approval_flow_id', $approvalFlow->id)
            ->where('step_order', $nextStepOrder)
            ->first();

        if (!$nextStep) {
            // Koniec flow, ustaw status jako zrealizowany
            $training->status = 'realized';
            $training->save();
            return;
        }

        // Ustaw status wg następnego kroku
        $training->status = $this->mapStepToStatus($nextStep);
        $training->save();

        // Aktualizacja bieżącego kroku, jeśli w modelu jest przechowywany
        // $training->current_step = $nextStepOrder;
        // $training->save();
    }

    protected function saveApprovalRecord(Training $training, User $user, string $decision, ?string $comment)
    {
        TrainingApproval::create([
            'training_id' => $training->id,
            'approver_id' => $user->id,
            'role' => $this->getUserRoleOnStep($user, $training),
            'decision' => $decision,
            'comment' => $comment,
        ]);
    }

    protected function getApprovalFlowForTraining(Training $training): ?ApprovalFlow
    {
        // Prosta logika wyboru flow, można ją rozbudować:
        // np. po typie szkolenia, kwocie, dziale itp.
        return ApprovalFlow::first();
    }

    protected function getCurrentStepOrder(Training $training): int
    {
        // Jeśli przechowujesz w treningu bieżący krok
        // return $training->current_step ?? 1;

        // Alternatywnie ustal najnowszy krok po zapisach w TrainingApproval
        $lastApproval = TrainingApproval::where('training_id', $training->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$lastApproval) {
            return 1;
        }

        $approvalFlow = $this->getApprovalFlowForTraining($training);
        $step = ApprovalFlowStep::where('approval_flow_id', $approvalFlow->id)
            ->where('approver_identifier', $lastApproval->role)
            ->first();

        return $step ? $step->step_order + 1 : 1;
    }

    protected function mapStepToStatus(ApprovalFlowStep $step): string
    {
        // Możesz mapować status szkolenia na podstawie kroku
        // np. 'awaiting_manager', 'awaiting_hr' itd.
        return match ($step->approver_identifier) {
            'manager' => 'awaiting_manager',
            'hr-approver' => 'awaiting_hr',
            'fico' => 'awaiting_fico',
            default => 'awaiting_manager',
        };
    }

    protected function mapStepToStatusByOrder(int $order): string
    {
        // Można uzupełnić odpowiednią mapę statusów
        return match ($order) {
            1 => 'awaiting_manager',
            2 => 'awaiting_hr',
            3 => 'awaiting_fico',
            default => 'awaiting_manager',
        };
    }

    protected function getUserRoleOnStep(User $user, Training $training): string
    {
        // Tutaj rozpoznaj rolę użytkownika na aktualnym kroku
        // np. sprawdź role, które pasują do bieżącego kroku approval flow
        return $user->roles()->first()->name ?? 'unknown';
    }
}
