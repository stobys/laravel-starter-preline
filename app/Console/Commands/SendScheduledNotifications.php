<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\ScheduledNotification;
use App\Jobs\SendScheduledNotificationJob;

class SendScheduledNotifications extends Command
{
    protected $signature = 'notifications:send-scheduled';
    protected $description = 'Wysyła zaplanowane powiadomienia';

    public function handle()
    {
        $notifications = ScheduledNotification::query()
            ->where('scheduled_at', '<=', now())
            ->where('sent_at', null)
            ->get();

        foreach ($notifications as $notification) {
            SendScheduledNotificationJob::dispatch($notification);
        }

        $this->info('Dispatchowano ' . $notifications->count() . ' powiadomień do wysyłki.');
    }


    public function test()
    {
        // foreach ($notifications as $scheduledNotification) {
        //     if ($scheduledNotification->notification_class === EvaluationReminderNotification::class) {
        //         $trainingId = $scheduledNotification->notification_data['training_id'];

        //         $training = Training::find($trainingId);

        //         if (!$training || $training->evaluation_completed) {
        //             // Oznacz powiadomienie jako wysłane bez faktycznej wysyłki
        //             $scheduledNotification->update(['sent_at' => now()]);
        //             continue;
        //         }
        //     }

        //     $notifiable = $scheduledNotification->getNotifiable();
        //     $notifiable->notify($scheduledNotification->getNotificationInstance());
        //     $scheduledNotification->update(['sent_at' => now()]);
        // }
    }
}
