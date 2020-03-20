<?php

namespace MaxGaurav\LaravelSnsBroadcaster;

use Aws\Credentials\Credentials;
use Aws\Sns\SnsClient;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class LaravelSnsBroadcastProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     * @throws
     */
    public function boot()
    {
        $this->app->make(BroadcastManager::class)->extend('sns', function () {
            $client = new SnsClient([
                'version' => '2010-03-31',
                'region' => Config::get('sns-topics.config.region'),
                'credentials' => new Credentials(
                    Config::get('sns-topics.config.key'),
                    Config::get('sns-topics.config.secret')
                )
            ]);

            return new SnsBroadcaster(
                $client,
                Config::get('sns-topics.config.arn-prefix'),
                Config::get('sns-topics.config.suffix')
            );
        });
    }
}
