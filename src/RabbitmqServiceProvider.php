<?php

namespace Masoudi\Rabbitmq;

use Illuminate\Support\ServiceProvider;
use Masoudi\Rabbitmq\Contracts\RabbitmqConnector;

class RabbitmqServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var \Illuminate\Queue\QueueManager */
        $manager = $this->app->get('queue');
        $manager->addConnector('rabbitmq', fn () => new RabbitmqConnector);
    }
}
