<?php

namespace App\Console\Commands;

use App\Mail\TrackPrompt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class TrackOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a random daily track from spotify';

    protected $spotify;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $session = new Session(
            config('dailyspur.spotify.id'),
            config('dailyspur.spotify.secret')
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $this->spotify = new SpotifyWebAPI();
        $this->spotify->setAccessToken($accessToken);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $letter = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $index = array_rand($letter);

        $offset = mt_rand(1,100);

        $options = [
            'limit' => 1,
            'offset' => $offset,
        ];
        $looking = true;
        $count = 0;
        while($looking) {
            $count++;
            try {
                $tracks = $this->spotify->search($letter[$index] . '*', 'track', $options);
            }
            catch(\Exception $e) {
                $offset = mt_rand(1,100);
                continue;
            }
            $looking = false;
            dump($count);
        }


        $mail = new TrackPrompt($tracks->tracks->items[0]);

        //dd($mail->render());

        Mail::to(config('dailyspur.wordpress.to'))
            ->send($mail);


        // Spotify search
        //https://developer.spotify.com/console/get-search-item/?q=a*&type=track&market=&limit=1&offset=500
    }
}
