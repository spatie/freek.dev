<?php

namespace App\Services\Medium;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class MediumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Medium::class, function () {
            $integrationToken = config('services.medium.integration_token');

            $client = new Client([
                'base_uri' => 'https://api.medium.com/v1/',
                'headers' => [
                    'Authorization' => "Bearer {$integrationToken}",
                ],
            ]);


            return new Medium($client);
        });
    }
}
