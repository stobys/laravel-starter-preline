<?php

namespace App\Notifications;

use App\Models\Training;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TrainingFullyApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private ?Training $training = null;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private ?int $training_id = null,
    ) {
        // Załaduj training jeśli przekazano ID
        if ($this->training_id) {
            $this->training = Training::find($this->training_id);
        }

        // -- okreslenie konkretnej kolejki dla powiadomień
        // $this->onQueue('notifications');
    }

    /**
     * Możesz określić osobne kolejki dla różnych kanałów
     */
    // public function viaQueues(): array
    // {
    //     return [
    //         'mail' => 'mail-queue',
    //         'database' => 'notifications-queue',
    //     ];
    // }

    public function setTraining($training): self
    {
        if ($training instanceof Training) {
            $this->training = $training;
        }

        if(is_int($training)) {
            $this->training = Training::find($training);
        }

        return $this;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];

        // dynamicznie okreslanie kanalow powiadomienia na podstawie preferencji użytkownika
        $channels = [];

        if ($notifiable->notification_preferences['in_app'] ?? true) {
            $channels[] = 'database';
        }

        if ($notifiable->notification_preferences['email'] ?? true) {
            $channels[] = 'mail';
        }

        // // Łatwo dodawać nowe kanały
        // if ($notifiable->notification_preferences['sms'] ?? false) {
        //     $channels[] = SmsChannel::class;
        // }

        // if ($notifiable->notification_preferences['teams'] ?? false) {
        //     $channels[] = TeamsChannel::class;
        // }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('HeRMeS - szkolenie w pełni zaakceptowane')
            ->line("Zaakceptowano szkolenia: {$this->training->name}")
            // ->line("Przypisał: {$this->assignedBy->name}")
            ->action('Zobacz szczegóły', route('trainings.details', $this->training->id))
            ->line('Dziękujemy za korzystanie z naszej aplikacji!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        Log::info('Notifiable: ', ['notifiable' => $this->training]);

        return [
            'training_id' => $this->training->id,
            'training_name' => $this->training->name,
            'message' => "Zaakceptowano szkolenia: {$this->training->name}",
            'action_url' => route('trainings.details', $this->training->id),
        ];
    }

    // public function toDatabase(object $notifiable): array
    // {
    //     return [
    //         'training_id' => $this->training->id,
    //         'training_name' => $this->training->name,
    //         'message' => "Zaakceptowano szkolenia: {$this->training->name}",
    //         'action_url' => route('trainings.details', $this->training->id),
    //     ];
    // }

    // public function toSms(object $notifiable): string
    // {
    //     return "Zaakceptowano szkolenia: {$this->training->name}";
    // }

    // public function toTeams($notifiable): array
    // {
    //     return [
    //         'title' => 'Nowe szkolenie',
    //         'subtitle' => $this->training->name,
    //         'body' => "Zaakceptowano szkolenia: {$this->training->name}",
    //         'actions' => [
    //             [
    //                 '@type' => 'OpenUri',
    //                 'name' => 'Zobacz szczegóły',
    //                 'targets' => [
    //                     ['os' => 'default', 'uri' => route('trainings.details', $this->training->id)]
    //                 ]
    //             ]
    //         ]
    //     ];
    // }
}
