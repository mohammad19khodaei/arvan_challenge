<?php

namespace App\Services;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQ
{
    protected AMQPChannel $channel;

    public function __construct()
    {
        $this->setupChannel();
        $this->setupQueue();
    }

    protected function setupChannel(): void
    {
        $connection = new AMQPStreamConnection(
            '127.0.0.1',
            5672,
            'guest',
            'guest'
        );
        $this->channel = $connection->channel();
    }

    protected function setupQueue(): void
    {
        $this->channel->queue_declare('text_messages', false, true, false, false);
    }

    public function consume($callback)
    {
        $this->channel->basic_consume('text_messages', '', false, true, false, false, $callback);
  
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}
