<?php

namespace MaxGaurav\LaravelSnsBroadcaster;

use Aws\Sns\SnsClient;
use Illuminate\Contracts\Broadcasting\Broadcaster;
use Illuminate\Support\Arr;

class SnsBroadcaster implements Broadcaster
{
    /**
     * @var SnsClient
     */
    protected $snsClient;

    /**
     * @var string
     */
    protected $topicArn;

    /**
     * @var string
     */
    protected $suffix;

    /**
     * SnsBroadcaster constructor.
     *
     * @param SnsClient $client
     * @param string $topicArn
     * @param string $suffix
     */
    public function __construct(SnsClient $client, string $topicArn, string $suffix)
    {
        $this->snsClient = $client;
        $this->topicArn = $topicArn;
        $this->suffix = $suffix;
    }

    /**
     * @inheritDoc
     */
    public function broadcast(array $channels, $event, array $payload = [])
    {
        $this->snsClient->publish([
            'TopicArn' => $this->topicName($channels),
            'Message' => json_encode(Arr::except($payload, 'socket')),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function auth($request)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function validAuthenticationResponse($request, $result)
    {
        return true;
    }

    /**
     * Returns topic name built for sns
     *
     * @param array $channels
     * @return string
     */
    private function topicName(array $channels): string
    {
        return $this->topicArn . Arr::first($channels) . $this->suffix;
    }
}
