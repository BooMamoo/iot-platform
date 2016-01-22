<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Information;
use GuzzleHttp\Client;

class DataToServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends data from local to server';

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
        $informations = Information::All();
        $count = count($informations);

        if($count != 0)
        {
            $last_id = $informations[$count - 1]->id;

            $ip = config('ip');
            $url = $ip . '/data/store';
            $client = new Client();
            $local = config('local');

            $response = $client->request('POST', $url, [
                'json' => [
                    'data' => $informations, 
                    'parameter' => 'data', 
                    'local' => $local
                ]
            ]);

            // $file = '/home/vagrant/Code/iot-platform/test';
            // $current = $response->getBody()->getContents();
            // file_put_contents($file, $current);

            if($response->getBody()->getContents() == 'true')
            {
                Information::where('id', '<=', $last_id)->delete();
            }

            return $this->info('Data from Local A were sent successfully!');

        }
            
        return $this->info('Nothing to update');
    }
}
