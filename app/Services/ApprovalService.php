<?php
namespace App\Services;

use App\Models\User;
use App\Models\Approval;
use App\Events\ApprovalApproved;
use App\Events\ApprovalRejected;
use App\Events\ApprovalReturned;
use App\Events\ApprovalStepSkipped;

class ApprovalService
{
    public function approve($model, User $user, ?string $comment = null)
    {
        if (!$model->canBeApprovedBy($user)) {
            throw new \Exception('Nie masz uprawnień do zatwierdzenia');
        }

        $currentStep = $model->currentApprovalStep();

        // Zapisz akceptację
        Approval::where('approvable_type', get_class($model))
            ->where('approvable_id', $model->id)
            ->where('approval_flow_step_id', $currentStep->id)
            ->update([
                'status' => 'approved',
                'user_id' => $user->id,
                'comment' => $comment,
                'approved_at' => now(),
            ]);

        // Znajdź następny krok do wykonania (z uwzględnieniem warunków)
        $nextStep = $this->findNextExecutableStep($model, $currentStep);

        // Sprawdź czy są kolejne kroki
        // $nextStep = $currentStep->flow->steps()
        //     ->where('step_order', '>', $currentStep->step_order)
        //     ->orderBy('step_order')
        //     ->first();

        if ($nextStep) {
            // Przesuń do następnego kroku
            $model->approvalStatus->update([
                'current_step_id' => $nextStep->id,
            ]);

            Approval::create([
                'approvable_type' => get_class($model),
                'approvable_id' => $model->id,
                'approval_flow_step_id' => $nextStep->id,
                'status' => 'pending',
            ]);

            event(new ApprovalApproved($model, $currentStep, $nextStep));
        } else {
            // Zakończ proces - wszystkie kroki zatwierdzone
            $model->approvalStatus->update([
                'overall_status' => 'approved',
                'completed_at' => now(),
            ]);

            event(new ApprovalApproved($model, $currentStep, null));
        }
    }

    /**
     * Znajduje następny krok do wykonania, pomijając te które nie spełniają warunków
     */
    protected function findNextExecutableStep($model, $currentStep): ?ApprovalFlowStep
    {
        $steps = $currentStep->flow->steps()
            ->where('step_order', '>', $currentStep->step_order)
            ->orderBy('step_order')
            ->get();

        foreach ($steps as $step) {
            if ($step->shouldExecute($model)) {
                return $step;
            } else {
                // Loguj pominięty krok
                $this->logSkippedStep($model, $step);
            }
        }

        return null;
    }

    /**
     * Loguje pominięty krok
     */
    protected function logSkippedStep($model, $step): void
    {
        Approval::create([
            'approvable_type' => get_class($model),
            'approvable_id' => $model->id,
            'approval_flow_step_id' => $step->id,
            'status' => 'skipped',
            'comment' => 'Krok pominięty - warunek nie został spełniony',
            'approved_at' => now(),
        ]);

        event(new ApprovalStepSkipped($model, $step));
    }

    public function reject($model, User $user, string $comment)
    {
        if (!$model->canBeApprovedBy($user)) {
            throw new \Exception('Nie masz uprawnień do odrzucenia');
        }

        $currentStep = $model->currentApprovalStep();

        Approval::where('approvable_type', get_class($model))
            ->where('approvable_id', $model->id)
            ->where('approval_flow_step_id', $currentStep->id)
            ->update([
                'status' => 'rejected',
                'user_id' => $user->id,
                'comment' => $comment,
                'approved_at' => now(),
            ]);

        $model->approvalStatus->update([
            'overall_status' => 'rejected',
            'completed_at' => now(),
        ]);

        event(new ApprovalRejected($model, $user, $comment));
    }

    public function returnToPrevious($model, User $user, string $comment)
    {
        if (!$model->canBeApprovedBy($user)) {
            throw new \Exception('Nie masz uprawnień do cofnięcia');
        }

        $currentStep = $model->currentApprovalStep();

        if (!$currentStep->can_return) {
            throw new \Exception('Ten krok nie pozwala na cofnięcie');
        }

        $previousStep = $currentStep->flow->steps()
            ->where('step_order', '<', $currentStep->step_order)
            ->orderBy('step_order', 'desc')
            ->first();

        if (!$previousStep) {
            throw new \Exception('Brak poprzedniego kroku');
        }

        // Oznacz obecny jako zwrócony
        Approval::where('approvable_type', get_class($model))
            ->where('approvable_id', $model->id)
            ->where('approval_flow_step_id', $currentStep->id)
            ->update([
                'status' => 'returned',
                'user_id' => $user->id,
                'comment' => $comment,
                'approved_at' => now(),
            ]);

        // Wróć do poprzedniego kroku
        $model->approvalStatus->update([
            'current_step_id' => $previousStep->id,
        ]);

        Approval::create([
            'approvable_type' => get_class($model),
            'approvable_id' => $model->id,
            'approval_flow_step_id' => $previousStep->id,
            'status' => 'pending',
        ]);

        event(new ApprovalReturned($model, $currentStep, $previousStep, $comment));
    }
}
