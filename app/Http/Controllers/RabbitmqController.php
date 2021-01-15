<?php

namespace App\Http\Controllers;

use App\Transports\AmqpBunny;
use Interop\Amqp\Impl\AmqpBind;
use Illuminate\Http\Request;
use Interop\Amqp\AmqpTopic;
use Interop\Amqp\AmqpQueue;
use Interop\Queue\Message;
use Interop\Queue\Consumer;

class RabbitmqController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $context;

    public function __construct(AmqpBunny $amqpBunny)
    {
        $this->context = $amqpBunny::context();
    }

    //

    public function queueStats() 
    {
        $client = new \GuzzleHttp\Client();
    
        $res = $client->request('GET', 'http://localhost:15672/api/queues', [
            'auth' => ['guest', '1234']
        ]);

        return $res->getBody()->getContents();
    }

    public function consumeMessage(Request $request) 
    {
        $queue_name     = $request->get('queue_name');
        $fooQueue       = $this->context->createQueue($queue_name);
        $consumer       = $this->context->createConsumer($fooQueue);
        $message        = $consumer->receive();
        $messageBody    = json_decode($message->getBody(), TRUE);

        // $consumer->acknowledge($message);

        return response()->json(['response_code' => '00', 'message' => 'Success', 'data' => $messageBody], 200);
    }

    public function createProducer(Request $request) {

        $topic_name     = $request->get('topic_name');
        $queue_name     = $request->get('queue_name');
        $message        = json_encode($request->get('message'));

        /** create topic */
        $topic          = $this->context->createTopic($topic_name);

        $topic->setType(AmqpTopic::TYPE_FANOUT);
        $this->context->declareTopic($topic);
        /** */

        /** create queue */
        $queue          = $this->context->createQueue($queue_name);

        $queue->addFlag(AmqpQueue::FLAG_DURABLE);
        $this->context->declareQueue($queue);
        /** */

        /** create message */
        $message        = $this->context->createMessage($message);
        /** */

        /** producer */
        $this->context->createProducer()->send($queue, $message);
        /** */

        return response()->json(['response_code' => '00', 'message' => 'Success', 'data' =>  null], 200);
    }

}
