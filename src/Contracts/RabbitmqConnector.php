<?php

namespace Masoudi\Rabbitmq\Contracts;

use Illuminate\Queue\Connectors\ConnectorInterface;
use Masoudi\Rabbitmq\Queue\RabbitmqQueue;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitmqConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $connection = new AMQPStreamConnection(
            host: $config['host'],
            port: $config['port'],
            user: $config['user'],
            password: $config['password']
        );

        return new RabbitmqQueue($connection, $config['default_queue']);
    }
}
