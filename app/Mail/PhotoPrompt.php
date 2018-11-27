<?php

namespace App\Mail;

use Crew\Unsplash\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PhotoPrompt extends Mailable
{
    use Queueable, SerializesModels;

    public $photo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('dailyspur.wordpress.from'))
            ->subject($this->photo->description)
            ->view('email.dailyphoto');
    }
}
