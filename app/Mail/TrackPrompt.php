<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackPrompt extends Mailable
{
    use Queueable, SerializesModels;

    public $track;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($track)
    {
        $this->track = $track;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = $this->track->name;

        return $this->from(config('dailyspur.wordpress.from'))
            ->subject($title)
            ->view('email.dailytrack');
    }
}
