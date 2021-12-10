<?php

namespace App\Console\Commands;

use App\Mail\PhotoPrompt;
use Unsplash\HttpClient;
use Unsplash\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PhotoOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:photo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a random photo from unsplash.com to display as a prompt at the daily spur.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        HttpClient::init([
            'applicationId'	=> config('dailyspur.unsplash.access'),
            'secret'		=> config('dailyspur.unsplash.secret'),
            'callbackUrl'	=> 'urn:ietf:wg:oauth:2.0:oob',
            'utmSource' => config('dailyspur.unsplash.name')
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filters = [
            //'featured' => true,
            //'username' => 'andy_brunner',
            //'query'    => 'coffee',
            //'w'        => 100,
            //'h'        => 100
        ];
        $photo = Photo::random($filters);

        $mail = new PhotoPrompt($photo);

        //dd($mail->render());

        Mail::to(config('dailyspur.wordpress.to'))
            ->send($mail);

        return;

    }
}
