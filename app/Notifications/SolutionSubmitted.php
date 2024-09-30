<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Challenge;

class SolutionSubmitted extends Notification
{
    use Queueable;

    public $user;
    public $challenge;

    public function __construct(User $user, Challenge $challenge)
    {
        $this->user = $user;
        $this->challenge = $challenge;
    }

    public function via($notifiable)
    {
        return ['database']; // You can add 'mail' if you want email notifications too
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->user->name . ' submitted a solution to challenge "' . $this->challenge->title . '".',
            'user_id' => $this->user->id,
            'challenge_id' => $this->challenge->id,
        ];
    }
}
