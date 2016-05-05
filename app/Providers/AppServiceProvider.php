<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $server_ip_address = 'http://158.108.34.49';
        $local_name = 'LocalA';
        $path = '/var/www/html/iot-platform/';

        config([
            'ip' => $server_ip_address, 
            'local' => $local_name,
            'path' => $path
        ]);
    }
}
