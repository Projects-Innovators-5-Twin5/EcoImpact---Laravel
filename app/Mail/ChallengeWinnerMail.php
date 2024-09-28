<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChallengeWinnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $challenge;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $challenge
     */
    public function __construct($user, $challenge)
    {
        $this->user = $user;
        $this->challenge = $challenge;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Congratulations, You Won the Challenge!')
                    ->view('Emails.challengewinner')
                    ->with([
                        'user' => $this->user,
                        'challenge' => $this->challenge,
                    ]);
    }
}
