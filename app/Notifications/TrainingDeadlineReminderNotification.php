<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Training;

class TrainingDeadlineReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $trainingId;

    public function __construct($trainingId)
    {
        $this->trainingId = $trainingId;
    }

    /**
     * Sprawdź czy powiadomienie powinno być wysłane
     */
    public function shouldSend($notifiable): bool
    {
        $training = Training::find($this->trainingId);

        if (!$training) {
            return false;
        }

        // Wyślij tylko jeśli do deadline zostało mniej niż 3 dni i trening nie jest ukończony
        if ($training->deadline->diffInDays(now()) <= 3 && !$training->completed) {
            return true;
        }

        return false;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $training = Training::find($this->trainingId);

        return (new MailMessage)
            ->subject('Przypomnienie o ewaluacji szkolenia')
            ->line("Minęło 7 dni od ukończenia szkolenia '{$training->name}'.")
            ->line('Prosimy o wypełnienie ewaluacji.')
            ->action('Wypełnij ewaluację', url("/trainings/{$training->id}/evaluation"))
            ->line('Dziękujemy!');
    }

    public function toArray($notifiable)
    {
        $training = Training::find($this->trainingId);

        return [
            'training_id' => $training->id,
            'training_name' => $training->name,
            'message' => 'Prosimy o wypełnienie ewaluacji szkolenia.',
            'action_url' => url("/trainings/{$training->id}/evaluation"),
        ];
    }
}
