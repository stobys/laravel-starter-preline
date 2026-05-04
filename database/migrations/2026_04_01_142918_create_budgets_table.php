<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('fiscal_year')->unique();

            $table->unsignedInteger('q1_budget')->default(0);
            $table->unsignedInteger('q2_budget')->default(0);
            $table->unsignedInteger('q3_budget')->default(0);
            $table->unsignedInteger('q4_budget')->default(0);

			$table->unsignedInteger('annual_budget')->storedAs("q1_budget + q2_budget + q3_budget + q4_budget");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
