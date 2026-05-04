<?php

use App\Enums\TrainingStates;
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

        Schema::create('notifications', function (Blueprint $table) {
            // $table->id();
            // $table->foreignId('user_id')->constrained('users');
            // $table->string('message');

            // $table->timestamp('read_at')->nullable();

            // $table->timestamps();
            // $table->softDeletes();

            // -- Laravel's Notifications Table
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->foreignId('read_by')->nullable()->constrained('users');
            $table->timestamps();
        });

		Schema::create('notification_settings', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->string('action'); // 'order.placed', 'comment.reply'
			$table->boolean('email')->default(false);
			$table->boolean('sms')->default(false);
			$table->boolean('in_app')->default(true);

			$table->unique(['user_id', 'action']);
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
