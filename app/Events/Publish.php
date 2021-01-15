<?php

namespace App\Events;

use App\Transports\AmqpBunny;
use Interop\Amqp\AmqpTopic;
use Interop\Amqp\AmqpQueue;

class Publish extends Event
{
    
    public function __construct($message, $topic, $queue)
    {
        Publish::send($message, $topic, $queue);
    }

    public static function send($message, $topic_name, $queue_name) 
    {
        $context = AmqpBunny::context();

        /** create topic */
        $topic  = $context->createTopic($topic_name);

        $topic->setType(AmqpTopic::TYPE_FANOUT);
        $context->declareTopic($topic);
        /** */

        /** create queue */
        $queue  = $context->createQueue($queue_name);

        $queue->addFlag(AmqpQueue::FLAG_DURABLE);
        $context->declareQueue($queue);
        /** */

        /** create message */
        $message    = $context->createMessage($message);
        /** */

        /** producer */
        $context->createProducer()->send($queue, $message);
        /** */

    }
    
}