<?php

namespace Masoudi\Rabbitmq\Tests;

use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Queue\Connectors\ConnectorInterface;
use Illuminate\Queue\Queue;
use Masoudi\Rabbitmq\Contracts\RabbitmqConnector;
use Masoudi\Rabbitmq\Queue\RabbitmqQueue;

class RabbitmqDriverTest extends TestCase
{
    public function test_rabbitmq_connector_is_instance_of_queue_connector()
    {
        $rabbitmqConnectorMock = $this->mock(RabbitmqConnector::class);
        $this->assertInstanceOf(ConnectorInterface::class, $rabbitmqConnectorMock);
    }

    public function test_rabbitmqqueue_is_instance_of_queue()
    {
        $rabbitmqQueueMock = $this->mock(RabbitmqQueue::class);
        $this->assertInstanceOf(Queue::class, $rabbitmqQueueMock);
    }

    public function test_rabbitmqqueue_is_implements_queue_contract()
    {
        $rabbitmqQueueMock = $this->mock(RabbitmqQueue::class);
        $this->assertInstanceOf(QueueContract::class, $rabbitmqQueueMock);
    }

    public function test_rabbitmq_driver_is_registered()
    {
        $this->expectException(\PhpAmqpLib\Exception\AMQPIOException::class);

        /** @var \Illuminate\Queue\QueueManager */
        $manager = $this->app->get('queue');
        $manager->connection('rabbitmq');
    }
}
