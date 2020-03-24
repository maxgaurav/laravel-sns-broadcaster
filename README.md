# Broadcast Events as SNS Topic

The package allows you to broad laravel events as sns topic.

The queue also processes standard jobs pushed via laravel.

This package is a great use cases for applications beings deployed to microservices.

## Requirements

* PHP >= 7.2
* Laravel >= 6
* SQS driver for laravel
* SNS in AWS

## Installation

Install using composer
```sh
composer require maxgaurav/laravel-sns-sqs-queue
```

The package will automatically register its service provider.

## Configuration

### Driver setup
In **.env** use the broadcasting driver
```
BROADCAST_DRIVER=sns

```

### Environment Setup
```
TOPIC_SUFFIX=-dev #blank used if you are trying to deploy base

```

### Broadcaster Configuration Setup
In **queue.php** add the following driver setup

```php
return [

    'null' => [
        'driver' => 'null',
     ],

    'sns' => [
        'driver' => 'sns',
        'region' => env('AWS_DEFAULT_REGION'),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'suffix' => env('TOPIC_SUFFIX', '-dev'),
        'arn-prefix' => env('TOPIC_ARN_PREFIX', 'arn:aws:sns:us-east-2:123345666:') // note the arn prefix contains colon
    
    ],
];

```


## Event setup

In your events implement the **ShouldBroadcast** interface. And set the topic name to be return through **broadcastOn** method.

```php

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SampleEvent implements ShouldBroadcast
{

    /**
     * @inheritDoc
     */
    public function broadcastOn()
    {
        return "you topic"; // the topic without the prefix and suffix. Example user-created. If -dev is suffix then it will automatically appended
    }
}
```
