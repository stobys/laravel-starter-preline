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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
			$table->foreignId('department_id')->nullable();
			$table->foreignId('manager_id')->nullable()->constrained('users');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name')->storedAs("CONCAT(last_name, ', ', first_name)");
            $table->boolean('is_built_in')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->date('hired_at') -> nullable();
            $table->date('dismissed_at') -> nullable();

			$table -> foreignId('personal_id') -> nullable();
			$table -> string('teta_guid', 40) -> unique() -> nullable();
			$table -> foreignId('teta_prac_id') -> unique() -> nullable();
			$table -> tinyInteger('teta_grupa') -> nullable() -> comment('1 - Undefined, 2 - Direct, 4 - Indirect, 8 - Salaried');
			$table -> string('mpk_code', 10) -> nullable();

			$table->boolean('is_domain_user')->default(false);

            $table->softDeletes();
            $table->boolean('force_password_change')->default(false);
            $table->timestamp('password_changed_at')->nullable();
        });

        // Schema::create('user_profiles', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->unique();
        //     $table->string('bio')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

		Schema::create('user_delegations', function (Blueprint $table) {
            $table->id();
			$table->foreignId('principal_id')->constrained('users')->comment('kto jest zastępowany');
			$table->foreignId('substitute_id')->constrained('users')->comment('kto zastępuje');
            $table->datetime('valid_from')->nullable()->comment('od kiedy zastępstwo jest aktywne');
            $table->datetime('valid_to')->nullable()->comment('do kiedy zastępstwo jest aktywne');
            $table->string('comment')->nullable()->comment('komentarz do zastępstwa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::dropIfExists('user_delegations');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
