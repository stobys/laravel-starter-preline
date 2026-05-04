<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->string('name')->unique()->nullable();
            $table->string('abbr')->unique()->nullable();

			$table->foreignId('teta_mpk_id')-> unique()->nullable();
			$table->string('teta_mpk_code', 12)->unique()->nullable();
			$table->string('teta_name')->unique()->nullable();
			$table->string('teta_guid', 40)->unique()->nullable();

            $table->timestamps();
			$table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('set null'); // lub cascade, w zależności od potrzeb
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
