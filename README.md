> **⚠ WARNING: This package is not released yet.**  

# Laravel Rabbitmq Queue Driver
This is the queue driver package for the Laravel framework to help you to queue jobs on [RabbitMQ](https://www.rabbitmq.com). Now queue jobs with RabbitMQ fast and easy :)

![PHP Version](https://img.shields.io/badge/PHP-8.1-blue?style=for-the-badge&logo=php)
![PHP Version](https://img.shields.io/badge/Laravel-%5E7.0.1-red?style=for-the-badge&logo=laravel)

### How to setup
Add the package to your application
```bash
composer require masoudi/laravel-rabbitmq
```
Next, place the needed environment variables in the `.env` file
```js
QUEUE_CONNECTION=rabbitmq

RABBITMQ_HOST=127.0.0.1
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_DEFAULT_QUEUE=default
```
Finally, add connection settings in the `queue.php` config file in the `config` directory
```php
'connections' => [

        ...

        'rabbitmq' => [
            'driver' => 'rabbitmq',
            'host' => env('RABBITMQ_HOST', '127.0.0.1'),
            'port' => env('RABBITMQ_PORT', '5672'),
            'user' => env('RABBITMQ_USER', 'guest'),
            'password' => env('RABBITMQ_PASSWORD', 'guest'),
            'default_queue' => env('RABBITMQ_DEFAULT_QUEUE', 'default'),
        ]

    ],
```

Enjoy :)
