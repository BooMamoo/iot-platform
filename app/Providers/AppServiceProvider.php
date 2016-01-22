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
        $server_ip_address = 'http://192.168.1.49';
        $local_name = 'Local A';

        config([
            'ip' => $server_ip_address, 
            'local' => $local_name
        ]);
    }
}
