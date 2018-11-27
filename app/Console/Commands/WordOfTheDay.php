<?php

namespace App\Console\Commands;

use App\Mail\WordPrompt;
use Illuminate\Console\Command;
use App\DailySpur\Word;
use Illuminate\Support\Facades\Mail;

class WordOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:word';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a random word from the database and send it to the daily spur';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $test = 0;
        $count = 0;
        
        while($test == 0) {
            $count ++;
            $test = Word::where('times_used','<',$count)
                ->count();
        }
        
        $random = rand(1, $test);
        
        $word = Word::where('times_used','<',$count)->limit(1)->offset($random)->first();
        
        $word->times_used = $word->times_used + 1;
        $word->last_used = now()->toDateTimeString();
        $word->save();

        $mail = new WordPrompt($word);

        //dd($mail->render());

        Mail::to(config('dailyspur.wordpress.to'))
            ->send($mail);

        return;
    }
}
