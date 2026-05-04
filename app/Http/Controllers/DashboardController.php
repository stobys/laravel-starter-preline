<?php

namespace App\Http\Controllers;

use App\Enums\TrainingStatus;
use App\Models\Budget;
use App\Models\BudgetStat;
use App\Models\Training;
use App\Services\Filters\BudgetFiltersService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DashboardController extends Controller
{
    // public function __construct() {}

    public function stats($year = null)
    {
		return view('dashboard.budget-dashboard');
	}

    public function index($year = null)
    {
		$year = $year ?? Carbon::now()->getFiscalYear();

        $budgets = Budget::orderBy('fiscal_year', 'desc')->get();
		$budget = BudgetStat::where('fiscal_year', $year)->first();

		$manual = Budget::withCount('trainings') -> where('fiscal_year', $year) -> first();

		$annualByQuarterLabels = ['Q1', 'Q2', 'Q3', 'Q4'];
		$annualByQuarterTarget = [$budget->q1_budget, $budget->q2_budget, $budget->q3_budget, $budget->q4_budget];
		$annualByQuarterPlannedValues = [$budget->q1_planned_cost, $budget->q2_planned_cost, $budget->q3_planned_cost, $budget->q4_planned_cost];
		$annualByQuarterActualValues = [$budget->q1_actual_cost, $budget->q2_actual_cost, $budget->q3_actual_cost, $budget->q4_actual_cost];


		$annualByStateCount = [
			TrainingStatus::PLANNED->label()	=> $budget->annual_planned_trainings_count,
			TrainingStatus::PENDING->label()	=> $budget->annual_pending_trainings_count,
			TrainingStatus::APPROVED->label()	=> $budget->annual_approved_trainings_count,
			TrainingStatus::REJECTED->label()	=> $budget->annual_rejected_trainings_count,
			TrainingStatus::COMPLETED->label()	=> $budget->annual_completed_trainings_count,
			TrainingStatus::NOT_COMPLETED->label()	=> $budget->annual_not_completed_trainings_count,
			TrainingStatus::WITHDRAWN->label()	=> $budget->annual_withdrawn_trainings_count,
		];

		$annualByStatePercent = [
			TrainingStatus::PLANNED->label()	=> $budget->annual_trainings_count ? ($budget->annual_planned_trainings_count / $budget->annual_trainings_count * 100) : 0,
			TrainingStatus::PENDING->label()	=> $budget->annual_trainings_count ? ($budget->annual_pending_trainings_count / $budget->annual_trainings_count * 100) : 0,
			TrainingStatus::APPROVED->label()	=> $budget->annual_trainings_count ? ($budget->annual_approved_trainings_count / $budget->annual_trainings_count * 100) : 0,
			TrainingStatus::REJECTED->label()	=> $budget->annual_trainings_count ? ($budget->annual_rejected_trainings_count / $budget->annual_trainings_count * 100) : 0,
			TrainingStatus::COMPLETED->label()	=> $budget->annual_trainings_count ? ($budget->annual_completed_trainings_count / $budget->annual_trainings_count * 100) : 0,
			TrainingStatus::NOT_COMPLETED->label()	=> $budget->annual_trainings_count ? ($budget->annual_not_completed_trainings_count / $budget->annual_trainings_count * 100) : 0,
			TrainingStatus::WITHDRAWN->label()	=> $budget->annual_trainings_count ? ($budget->annual_withdrawn_trainings_count / $budget->annual_trainings_count * 100) : 0,
		];

		$stateColors = [
			TrainingStatus::PLANNED->color(),
			TrainingStatus::PENDING->color(),
			TrainingStatus::APPROVED->color(),
			TrainingStatus::REJECTED->color(),
			TrainingStatus::COMPLETED->color(),
			TrainingStatus::NOT_COMPLETED->color(),
			TrainingStatus::WITHDRAWN->color(),
		];

        return view('dashboard.dashboard', compact(
			'year', 'budgets', 'budget',
			'annualByQuarterLabels', 'annualByQuarterTarget', 'annualByQuarterPlannedValues', 'annualByQuarterActualValues',
			'annualByStateCount', 'annualByStatePercent', 'stateColors'
		));
    }

    public function filter(Request $request, BudgetFiltersService $filters)
    {
        $filters->save($request->only('filters'));
        return redirect()->route('budgets.index');
    }

}
