<?php

namespace App\Mail;

use App\DailySpur\Word;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WordPrompt extends Mailable
{
    use Queueable, SerializesModels;
    public $word;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Word $word)
    {
        $this->word = $word;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('dailyspur.wordpress.from'))
            ->subject($this->word->word)
            ->view('email.dailyword');
    }
}
