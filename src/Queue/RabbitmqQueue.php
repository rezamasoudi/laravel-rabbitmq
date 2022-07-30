<?php

namespace Masoudi\Rabbitmq\Queue;

use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Queue\Queue;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitmqQueue extends Queue implements QueueContract
{
    private AMQPChannel $channel;

    public function __construct(private AMQPStreamConnection $connection, private string $defaultQueue)
    {
        $this->channel = $this->connection->channel();
    }

    /**
     * Get the size of the queue.
     *
     * @param  null|string  $queue
     * @return int
     */
    public function size($queue = null)
    {
    }

    /**
     * Push a new job onto the queue.
     *
     * @param  object|string  $job
     * @param  mixed  $data
     * @param  null|string  $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        $this->channel->queue_declare($queue ?? $this->defaultQueue, false, false, false, false);
        $message = new \PhpAmqpLib\Message\AMQPMessage(serialize($job));
        $this->channel->basic_publish($message, '', $queue ?? $this->defaultQueue);
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * Push a raw payload onto the queue.
     *
     * @param  string  $payload
     * @param  null|string  $queue
     * @param  array  $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
    }

    /**
     * Push a new job onto the queue after (n) seconds.
     *
     * @param  \DateInterval|\DateTimeInterface|int  $delay
     * @param  object|string  $job
     * @param  mixed  $data
     * @param  null|string  $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
    }

    /**
     * Pop the next job off of the queue.
     *
     * @param  null|string  $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     */
    public function pop($queue = null)
    {
        $this->channel->queue_declare($queue ?? $this->defaultQueue, false, false, false, false);
        $callback = function ($amqpMessage) {
            $job = unserialize($amqpMessage->getBody());
            $job->handle();
        };

        $this->channel->basic_consume($queue ?? $this->defaultQueue, '', false, true, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
    }
}
