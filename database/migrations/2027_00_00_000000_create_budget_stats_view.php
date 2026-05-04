<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

// database/migrations/xxxx_create_budget_stats_view.php
return new class extends Migration
{
	public function up(): void
	{
		// Artisan::call('dashboard:view', ['action' => 'create']);
	}

	public function down(): void
	{
		// Artisan::call('dashboard:view', ['action' => 'drop']);
	}
};
