<?php

namespace App\Events;

use App\Transports\AmqpBunny;
use Interop\Amqp\AmqpTopic;
use Interop\Amqp\AmqpQueue;

class Subscribe extends Event
{
    
    public function __construct($queue)
    {
        // 
    }

    public static function consume($queue_name) 
    {
        $context        = AmqpBunny::context();
        $queue          = $context->createQueue($queue_name);
        $consumer       = $context->createConsumer($queue);
        $message        = $consumer->receive();
        $messageBody    = json_decode($message->getBody(), TRUE);
        
        $consumer->acknowledge($message);

        return $messageBody;
    }
    
}