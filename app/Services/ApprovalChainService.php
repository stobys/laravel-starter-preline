<?php

namespace App\Services;

use App\Models\Trening;
use App\Models\User;
use App\States\Trening\{PendingManager, PendingHR, PendingFinance};
use App\States\Trening\Transitions\{ManagerApproves, HRApproves, FinanceApproves};

class ApprovalChainService
{
    /**
     * Wykonaj wszystkie możliwe auto-approvals
     */
    public function processAutoApprovals(Trening $trening): void
    {
        $maxIterations = 10; // Zabezpieczenie przed nieskończoną pętlą
        $iterations = 0;

        while ($iterations < $maxIterations) {
            $currentState = $trening->state::class;

            // Sprawdź czy możemy auto-approve na obecnym kroku
            if (!$this->canAutoApprove($trening)) {
                break;
            }

            // Wykonaj auto-approval
            $this->executeAutoApproval($trening);

            // Reload model
            $trening->refresh();

            // Jeśli stan się nie zmienił, przerwij
            if ($trening->state::class === $currentState) {
                break;
            }

            $iterations++;
        }
    }

    private function canAutoApprove(Trening $trening): bool
    {
        return match($trening->state::class) {
            PendingManager::class => $this->canAutoApproveByManager($trening),
            PendingHR::class => $this->canAutoApproveByHR($trening),
            PendingFinance::class => $this->canAutoApproveByFinance($trening),
            default => false,
        };
    }

    private function executeAutoApproval(Trening $trening): void
    {
        $systemUser = $this->getSystemUser();

        $transitionClass = match($trening->state::class) {
            PendingManager::class => new ManagerApproves($trening, $systemUser, 'Auto-approved'),
            PendingHR::class => new HRApproves($trening, $systemUser, 'Auto-approved'),
            PendingFinance::class => new FinanceApproves($trening, $systemUser, 'Auto-approved'),
            default => null,
        };

        if ($transitionClass) {
            $trening->state->transitionTo($transitionClass);
        }
    }

    private function canAutoApproveByManager(Trening $trening): bool
    {
        // Twoja logika - np. koszt < 500
        return $trening->cost < 500;
    }

    private function canAutoApproveByHR(Trening $trening): bool
    {
        // Np. dla tych samych szkoleń co w poprzednim miesiącu
        return false;
    }

    private function canAutoApproveByFinance(Trening $trening): bool
    {
        return false;
    }
}
