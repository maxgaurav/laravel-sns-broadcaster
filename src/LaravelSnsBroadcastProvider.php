<?php

namespace MaxGaurav\LaravelSnsBroadcaster;

use Aws\Sns\SnsClient;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\Arr;
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
        $this->app->make(BroadcastManager::class)->extend('sns', function ($app, $config) {
            $client = new SnsClient($this->getSnsClientConfig($config));

            return new SnsBroadcaster(
                $client,
                $config['arn-prefix'],
                $config['suffix']
            );
        });
    }

    public function getSnsClientConfig($config)
    {
        $snsConfig = [
            'region' => $config['region'],
            'version' => 'latest',
        ];

        if (!empty($config['key']) && !empty($config['secret'])) {
            $snsConfig['credentials'] = Arr::only(
                $config, ['key', 'secret', 'token']
            );
        }

        if(!empty($config['options']) && is_array($config['options'])) {
            $snsConfig = array_merge($snsConfig, $config['options']);
        }

        return $snsConfig;
    }
}
