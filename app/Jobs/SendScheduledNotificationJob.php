<?php

namespace App\Jobs;

use App\Models\Training;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\ScheduledNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\EvaluationReminderNotification;

class SendScheduledNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;

    public function __construct(ScheduledNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle()
    {
        $notifiable = $this->notification->notifiable;
        $notificationClass = $this->notification->notification_class;
        $notificationData = $this->notification->notification_data;

        // Utwórz instancję powiadomienia
        $notification = new $notificationClass(...array_values($notificationData));

        // Sprawdź czy powiadomienie ma metodę shouldSend i czy powinna być wysłana
        if (method_exists($notification, 'shouldSend')) {
            if (!$notification->shouldSend($notifiable)) {
                // Nie wysyłaj, tylko oznacz jako przetworzone
                $this->notification->markSent();
                return;
            }
        }

        // Wyślij powiadomienie
        $notifiable->notify($notification);

        // Oznacz jako wysłane
        $this->notification->markSent();
    }

    public function handle2()
    {
        $notifiable = $this->notification->getNotifiable();

        if (!$notifiable) {
            Log::warning('ScheduledNotification: Notifiable not found', [
                'notification_id' => $this->notification->id,
            ]);
            $this->notification->markSent();
            return;
        }

        // Sprawdź warunki biznesowe (jeśli potrzebne)
        if (!$this->shouldSendNotification()) {
            Log::info('ScheduledNotification: Conditions not met, skipping', [
                'notification_id' => $this->notification->id,
                'notification_class' => $this->notification->notification_class,
            ]);
            $this->notification->markSent();
            return;
        }

        // Utwórz instancję powiadomienia
        $notificationInstance = $this->notification->getNotificationInstance();

        Log::info('ScheduledNotification: Sending notification', [
            'notification_id' => $this->notification->id,
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id,
            'notification_class' => $this->notification->notification_class,
        ]);

        // Wyślij powiadomienie
        $notifiable->notify($notificationInstance);

        // Oznacz jako wysłane
        $this->notification->markSent();

        /// ----
        // Sprawdź czy to przypomnienie o ewaluacji
        if ($this->notification->notification_class === EvaluationReminderNotification::class) {
            $training = $this->notification->notification_data['training'];

            // Sprawdź czy ewaluacja nie została już wykonana
            if ($training['evaluation_completed'] ?? false) {
                // Anuluj wysyłkę - ewaluacja już zrobiona
                $this->notification->update(['sent_at' => now()]);
                return;
            }
        }

        // Wyślij powiadomienie
        $notifiable = $this->notification->notifiable;
        $notificationClass = $this->notification->notification_class;
        $notificationData = $this->notification->notification_data;

        $notification = new $notificationClass(...array_values($notificationData));
        $notifiable->notify($notification);

        // Oznacz jako wysłane
        $this->notification->update(['sent_at' => now()]);
    }

}
