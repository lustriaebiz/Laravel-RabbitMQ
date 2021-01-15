<?php

namespace App\Transports;
use Enqueue\AmqpBunny\AmqpConnectionFactory;

class AmqpBunny
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public static function context()
    {
        $config     = [
            'host'      => env('RABBITMQ_HOST', null),
            'port'      => env('RABBITMQ_PORT', null),
            'vhost'     => env('RABBITMQ_VHOST', null),
            'user'      => env('RABBITMQ_LOGIN', null),
            'pass'      => env('RABBITMQ_PASSWORD', null),
            'persisted' => false,
        ];

        $factory    = new AmqpConnectionFactory($config);

        $context    = $factory->createContext();

        return $context;
    }
    
}
