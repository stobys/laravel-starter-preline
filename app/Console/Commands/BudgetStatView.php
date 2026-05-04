<?php

namespace App\Console\Commands;

use App\Models\NullModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BudgetStatView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:view {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage Budget Stats DB View';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $action  = strtolower($this->argument('action'));

        switch ($action) {
            case 'drop':
				$this->dropView();
            break;

            case 'create':
                $this->createView();
            break;
        }
    }

	public function dropView()
	{
		DB::statement("DROP VIEW IF EXISTS budget_stats");
	}

	public function createView()
	{
		DB::statement("
			CREATE OR REPLACE VIEW budget_stats AS
			WITH training_costs AS (
				-- Agregacja kosztów i liczby szkoleń BEZ join z participant_training
				-- Każde szkolenie liczone raz, niezależnie od liczby uczestników
				SELECT
					fiscal_year,
					fiscal_quarter,
					state,

					COUNT(id)                           	AS trainings_count,
					CAST(COALESCE(SUM(planned_cost), 0) AS DECIMAL(15,4))      	AS planned_cost,
					CAST(COALESCE(SUM(actual_cost),  0) AS DECIMAL(15,4))      	AS actual_cost,

					COUNT(CASE WHEN state = 'planned'   	THEN id END) AS planned_trainings_count,
    				COUNT(CASE WHEN state = 'pending'		THEN id END) AS pending_trainings_count,
    				COUNT(CASE WHEN state = 'approved'		THEN id END) AS approved_trainings_count,
    				COUNT(CASE WHEN state = 'rejected'		THEN id END) AS rejected_trainings_count,
    				COUNT(CASE WHEN state = 'completed'		THEN id END) AS completed_trainings_count,
    				COUNT(CASE WHEN state = 'not_completed'	THEN id END) AS not_completed_trainings_count,
    				COUNT(CASE WHEN state = 'withdrawn'		THEN id END) AS withdrawn_trainings_count
				FROM trainings
				WHERE deleted_at IS NULL
				GROUP BY fiscal_year, fiscal_quarter, state
			),
			training_participants AS (
				-- Agregacja uczestników osobno
				SELECT
					t.fiscal_year,
					t.fiscal_quarter,

					COUNT(pt.id)                        AS participants_count,
					COUNT(DISTINCT pt.participant_id)   AS unique_participants_count
				FROM trainings t
				LEFT JOIN participant_training pt ON pt.training_id = t.id
				WHERE t.deleted_at IS NULL
				GROUP BY t.fiscal_year, t.fiscal_quarter
			),
			quarterly AS (
				SELECT
					b.id                AS budget_id,
					b.fiscal_year,
					b.annual_budget,
					b.q1_budget,
					b.q2_budget,
					b.q3_budget,
					b.q4_budget,

					-- ── Koszty per kwartał ────────────────────────────────────────
					COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.planned_cost END), 0)  AS q1_planned_cost,
					COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.planned_cost END), 0)  AS q2_planned_cost,
					COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.planned_cost END), 0)  AS q3_planned_cost,
					COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.planned_cost END), 0)  AS q4_planned_cost,

					COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.actual_cost END), 0)   AS q1_actual_cost,
					COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.actual_cost END), 0)   AS q2_actual_cost,
					COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.actual_cost END), 0)   AS q3_actual_cost,
					COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.actual_cost END), 0)   AS q4_actual_cost,

					-- ── Liczba szkoleń per kwartał ────────────────────────────────
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.trainings_count END), 0) AS UNSIGNED) AS q1_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.trainings_count END), 0) AS UNSIGNED) AS q2_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.trainings_count END), 0) AS UNSIGNED) AS q3_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.trainings_count END), 0) AS UNSIGNED) AS q4_trainings_count,

					-- ── Planned per kwartał ──────────────────────────
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.planned_trainings_count END), 0) AS UNSIGNED) AS q1_planned_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.planned_trainings_count END), 0) AS UNSIGNED) AS q2_planned_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.planned_trainings_count END), 0) AS UNSIGNED) AS q3_planned_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.planned_trainings_count END), 0) AS UNSIGNED) AS q4_planned_trainings_count,

					-- ── Pending per kwartał ──────────────────────────
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.pending_trainings_count END), 0) AS UNSIGNED) AS q1_pending_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.pending_trainings_count END), 0) AS UNSIGNED) AS q2_pending_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.pending_trainings_count END), 0) AS UNSIGNED) AS q3_pending_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.pending_trainings_count END), 0) AS UNSIGNED) AS q4_pending_trainings_count,

					-- ── Approved per kwartał ──────────────────────────
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.approved_trainings_count END), 0) AS UNSIGNED) AS q1_approved_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.approved_trainings_count END), 0) AS UNSIGNED) AS q2_approved_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.approved_trainings_count END), 0) AS UNSIGNED) AS q3_approved_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.approved_trainings_count END), 0) AS UNSIGNED) AS q4_approved_trainings_count,

					-- ── Rejected per kwartał ──────────────────────────
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.rejected_trainings_count END), 0) AS UNSIGNED) AS q1_rejected_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.rejected_trainings_count END), 0) AS UNSIGNED) AS q2_rejected_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.rejected_trainings_count END), 0) AS UNSIGNED) AS q3_rejected_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.rejected_trainings_count END), 0) AS UNSIGNED) AS q4_rejected_trainings_count,

					-- ── Completed per kwartał ──────────────────────────
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.completed_trainings_count END), 0) AS UNSIGNED) AS q1_completed_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.completed_trainings_count END), 0) AS UNSIGNED) AS q2_completed_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.completed_trainings_count END), 0) AS UNSIGNED) AS q3_completed_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.completed_trainings_count END), 0) AS UNSIGNED) AS q4_completed_trainings_count,

					-- ── Not Completed per kwartał ──────────────────────────
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.not_completed_trainings_count END), 0) AS UNSIGNED) AS q1_not_completed_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.not_completed_trainings_count END), 0) AS UNSIGNED) AS q2_not_completed_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.not_completed_trainings_count END), 0) AS UNSIGNED) AS q3_not_completed_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.not_completed_trainings_count END), 0) AS UNSIGNED) AS q4_not_completed_trainings_count,

					-- ── Withdrawn per kwartał ──────────────────────────
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 1 THEN tc.withdrawn_trainings_count END), 0) AS UNSIGNED) AS q1_withdrawn_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 2 THEN tc.withdrawn_trainings_count END), 0) AS UNSIGNED) AS q2_withdrawn_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 3 THEN tc.withdrawn_trainings_count END), 0) AS UNSIGNED) AS q3_withdrawn_trainings_count,
					CAST(COALESCE(SUM(CASE WHEN tc.fiscal_quarter = 4 THEN tc.withdrawn_trainings_count END), 0) AS UNSIGNED) AS q4_withdrawn_trainings_count,

					-- ── Uczestnicy per kwartał (z osobnego CTE) ───────────────────
					CAST(COALESCE(MAX(CASE WHEN tp.fiscal_quarter = 1 THEN tp.participants_count END), 0) AS UNSIGNED)        AS q1_participants_count,
					CAST(COALESCE(MAX(CASE WHEN tp.fiscal_quarter = 2 THEN tp.participants_count END), 0) AS UNSIGNED)        AS q2_participants_count,
					CAST(COALESCE(MAX(CASE WHEN tp.fiscal_quarter = 3 THEN tp.participants_count END), 0) AS UNSIGNED)        AS q3_participants_count,
					CAST(COALESCE(MAX(CASE WHEN tp.fiscal_quarter = 4 THEN tp.participants_count END), 0) AS UNSIGNED)        AS q4_participants_count,

					CAST(COALESCE(MAX(CASE WHEN tp.fiscal_quarter = 1 THEN tp.unique_participants_count END), 0) AS UNSIGNED) AS q1_unique_participants_count,
					CAST(COALESCE(MAX(CASE WHEN tp.fiscal_quarter = 2 THEN tp.unique_participants_count END), 0) AS UNSIGNED) AS q2_unique_participants_count,
					CAST(COALESCE(MAX(CASE WHEN tp.fiscal_quarter = 3 THEN tp.unique_participants_count END), 0) AS UNSIGNED) AS q3_unique_participants_count,
					CAST(COALESCE(MAX(CASE WHEN tp.fiscal_quarter = 4 THEN tp.unique_participants_count END), 0) AS UNSIGNED) AS q4_unique_participants_count,

					b.created_at,
					b.updated_at

				FROM budgets b
				LEFT JOIN training_costs tc
					ON tc.fiscal_year = b.fiscal_year
				LEFT JOIN training_participants tp
					ON  tp.fiscal_year    = b.fiscal_year
					AND tp.fiscal_quarter = tc.fiscal_quarter
				GROUP BY
					b.id, b.fiscal_year, b.annual_budget,
					b.q1_budget, b.q2_budget, b.q3_budget, b.q4_budget,
					b.created_at, b.updated_at
			),
			annual_unique AS (
				-- Annual unique participants — osobny CTE, nie suma kwartalnych
				SELECT
					t.fiscal_year,
					COUNT(DISTINCT pt.participant_id) AS annual_unique_participants_count
				FROM trainings t
				LEFT JOIN participant_training pt ON pt.training_id = t.id
				WHERE t.deleted_at IS NULL
				GROUP BY t.fiscal_year
			)

			SELECT
				q.budget_id                         AS id,
				q.fiscal_year,
				q.annual_budget,
				q.q1_budget,
				q.q2_budget,
				q.q3_budget,
				q.q4_budget,

				-- ════════════════════════════════════════════
				--  ANNUAL
				-- ════════════════════════════════════════════
				q.q1_planned_cost + q.q2_planned_cost + q.q3_planned_cost + q.q4_planned_cost   AS annual_planned_cost,
				q.q1_actual_cost  + q.q2_actual_cost  + q.q3_actual_cost  + q.q4_actual_cost    AS annual_actual_cost,

				q.q1_trainings_count + q.q2_trainings_count + q.q3_trainings_count + q.q4_trainings_count
					AS annual_trainings_count,

				q.q1_planned_trainings_count + q.q2_planned_trainings_count + q.q3_planned_trainings_count + q.q4_planned_trainings_count
					AS annual_planned_trainings_count,
				q.q1_pending_trainings_count + q.q2_pending_trainings_count + q.q3_pending_trainings_count + q.q4_pending_trainings_count
					AS annual_pending_trainings_count,
				q.q1_approved_trainings_count + q.q2_approved_trainings_count + q.q3_approved_trainings_count + q.q4_approved_trainings_count
					AS annual_approved_trainings_count,
				q.q1_rejected_trainings_count + q.q2_rejected_trainings_count + q.q3_rejected_trainings_count + q.q4_rejected_trainings_count
					AS annual_rejected_trainings_count,
				q.q1_completed_trainings_count + q.q2_completed_trainings_count + q.q3_completed_trainings_count + q.q4_completed_trainings_count
					AS annual_completed_trainings_count,
				q.q1_not_completed_trainings_count + q.q2_not_completed_trainings_count + q.q3_not_completed_trainings_count + q.q4_not_completed_trainings_count
					AS annual_not_completed_trainings_count,
				q.q1_withdrawn_trainings_count + q.q2_withdrawn_trainings_count + q.q3_withdrawn_trainings_count + q.q4_withdrawn_trainings_count
					AS annual_withdrawn_trainings_count,

				q.q1_participants_count + q.q2_participants_count
					+ q.q3_participants_count + q.q4_participants_count                          AS annual_participants_count,

				CAST(COALESCE(au.annual_unique_participants_count, 0) AS UNSIGNED)               AS annual_unique_participants_count,

				-- ── Annual utilization % ──────────────────────────────────────────
				ROUND(
					(q.q1_planned_cost + q.q2_planned_cost + q.q3_planned_cost + q.q4_planned_cost)
					/ NULLIF(q.annual_budget, 0) * 100, 2
				)                                                                                AS annual_budget_planned_utilization_pct,
				ROUND(
					(q.q1_actual_cost + q.q2_actual_cost + q.q3_actual_cost + q.q4_actual_cost)
					/ NULLIF(q.annual_budget, 0) * 100, 2
				)                                                                                AS annual_budget_actual_utilization_pct,

				-- ── Annual średni koszt szkolenia ─────────────────────────────────
				ROUND(
					(q.q1_planned_cost + q.q2_planned_cost + q.q3_planned_cost + q.q4_planned_cost)
					/ NULLIF(q.q1_trainings_count + q.q2_trainings_count + q.q3_trainings_count + q.q4_trainings_count, 0), 2
				)                                                                                AS annual_avg_training_planned_cost,
				ROUND(
					(q.q1_actual_cost + q.q2_actual_cost + q.q3_actual_cost + q.q4_actual_cost)
					/ NULLIF(q.q1_trainings_count + q.q2_trainings_count + q.q3_trainings_count + q.q4_trainings_count, 0), 2
				)                                                                                AS annual_avg_training_actual_cost,

				-- ── Annual średni koszt na uczestnika ─────────────────────────────
				ROUND(
					(q.q1_planned_cost + q.q2_planned_cost + q.q3_planned_cost + q.q4_planned_cost)
					/ NULLIF(q.q1_participants_count + q.q2_participants_count + q.q3_participants_count + q.q4_participants_count, 0), 2
				)                                                                                AS annual_avg_planned_cost_per_participant,
				ROUND(
					(q.q1_actual_cost + q.q2_actual_cost + q.q3_actual_cost + q.q4_actual_cost)
					/ NULLIF(q.q1_participants_count + q.q2_participants_count + q.q3_participants_count + q.q4_participants_count, 0), 2
				)                                                                                AS annual_avg_actual_cost_per_participant,

				-- ════════════════════════════════════════════
				--  Q1
				-- ════════════════════════════════════════════
				q.q1_planned_cost,
				q.q1_actual_cost,
				q.q1_trainings_count,
				q.q1_planned_trainings_count,
				q.q1_pending_trainings_count,
				q.q1_approved_trainings_count,
				q.q1_rejected_trainings_count,
				q.q1_completed_trainings_count,
				q.q1_not_completed_trainings_count,
				q.q1_withdrawn_trainings_count,
				q.q1_participants_count,
				q.q1_unique_participants_count,
				ROUND(q.q1_planned_cost / NULLIF(q.q1_budget, 0) * 100, 2)                      AS q1_budget_planned_utilization_pct,
				ROUND(q.q1_actual_cost  / NULLIF(q.q1_budget, 0) * 100, 2)                      AS q1_budget_actual_utilization_pct,
				ROUND(q.q1_planned_cost / NULLIF(q.q1_trainings_count, 0), 2)                   AS q1_avg_training_planned_cost,
				ROUND(q.q1_actual_cost  / NULLIF(q.q1_trainings_count, 0), 2)                   AS q1_avg_training_actual_cost,
				ROUND(q.q1_planned_cost / NULLIF(q.q1_participants_count, 0), 2)                AS q1_avg_planned_cost_per_participant,
				ROUND(q.q1_actual_cost  / NULLIF(q.q1_participants_count, 0), 2)                AS q1_avg_actual_cost_per_participant,

				-- ════════════════════════════════════════════
				--  Q2
				-- ════════════════════════════════════════════
				q.q2_planned_cost,
				q.q2_actual_cost,
				q.q2_trainings_count,
				q.q2_planned_trainings_count,
				q.q2_pending_trainings_count,
				q.q2_approved_trainings_count,
				q.q2_rejected_trainings_count,
				q.q2_completed_trainings_count,
				q.q2_not_completed_trainings_count,
				q.q2_withdrawn_trainings_count,
				q.q2_participants_count,
				q.q2_unique_participants_count,
				ROUND(q.q2_planned_cost / NULLIF(q.q2_budget, 0) * 100, 2)                      AS q2_budget_planned_utilization_pct,
				ROUND(q.q2_actual_cost  / NULLIF(q.q2_budget, 0) * 100, 2)                      AS q2_budget_actual_utilization_pct,
				ROUND(q.q2_planned_cost / NULLIF(q.q2_trainings_count, 0), 2)                   AS q2_avg_training_planned_cost,
				ROUND(q.q2_actual_cost  / NULLIF(q.q2_trainings_count, 0), 2)                   AS q2_avg_training_actual_cost,
				ROUND(q.q2_planned_cost / NULLIF(q.q2_participants_count, 0), 2)                AS q2_avg_planned_cost_per_participant,
				ROUND(q.q2_actual_cost  / NULLIF(q.q2_participants_count, 0), 2)                AS q2_avg_actual_cost_per_participant,

				-- ════════════════════════════════════════════
				--  Q3
				-- ════════════════════════════════════════════
				q.q3_planned_cost,
				q.q3_actual_cost,
				q.q3_trainings_count,
				q.q3_planned_trainings_count,
				q.q3_pending_trainings_count,
				q.q3_approved_trainings_count,
				q.q3_rejected_trainings_count,
				q.q3_completed_trainings_count,
				q.q3_not_completed_trainings_count,
				q.q3_withdrawn_trainings_count,
				q.q3_participants_count,
				q.q3_unique_participants_count,
				ROUND(q.q3_planned_cost / NULLIF(q.q3_budget, 0) * 100, 2)                      AS q3_budget_planned_utilization_pct,
				ROUND(q.q3_actual_cost  / NULLIF(q.q3_budget, 0) * 100, 2)                      AS q3_budget_actual_utilization_pct,
				ROUND(q.q3_planned_cost / NULLIF(q.q3_trainings_count, 0), 2)                   AS q3_avg_training_planned_cost,
				ROUND(q.q3_actual_cost  / NULLIF(q.q3_trainings_count, 0), 2)                   AS q3_avg_training_actual_cost,
				ROUND(q.q3_planned_cost / NULLIF(q.q3_participants_count, 0), 2)                AS q3_avg_planned_cost_per_participant,
				ROUND(q.q3_actual_cost  / NULLIF(q.q3_participants_count, 0), 2)                AS q3_avg_actual_cost_per_participant,

				-- ════════════════════════════════════════════
				--  Q4
				-- ════════════════════════════════════════════
				q.q4_planned_cost,
				q.q4_actual_cost,
				q.q4_trainings_count,
				q.q4_planned_trainings_count,
				q.q4_pending_trainings_count,
				q.q4_approved_trainings_count,
				q.q4_rejected_trainings_count,
				q.q4_completed_trainings_count,
				q.q4_not_completed_trainings_count,
				q.q4_withdrawn_trainings_count,
				q.q4_participants_count,
				q.q4_unique_participants_count,
				ROUND(q.q4_planned_cost / NULLIF(q.q4_budget, 0) * 100, 2)                      AS q4_budget_planned_utilization_pct,
				ROUND(q.q4_actual_cost  / NULLIF(q.q4_budget, 0) * 100, 2)                      AS q4_budget_actual_utilization_pct,
				ROUND(q.q4_planned_cost / NULLIF(q.q4_trainings_count, 0), 2)                   AS q4_avg_training_planned_cost,
				ROUND(q.q4_actual_cost  / NULLIF(q.q4_trainings_count, 0), 2)                   AS q4_avg_training_actual_cost,
				ROUND(q.q4_planned_cost / NULLIF(q.q4_participants_count, 0), 2)                AS q4_avg_planned_cost_per_participant,
				ROUND(q.q4_actual_cost  / NULLIF(q.q4_participants_count, 0), 2)                AS q4_avg_actual_cost_per_participant,

				q.created_at,
				q.updated_at

			FROM quarterly q
			LEFT JOIN annual_unique au ON au.fiscal_year = q.fiscal_year;
		");

	}

}


