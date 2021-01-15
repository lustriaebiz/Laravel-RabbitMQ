<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\Publish;

class Publisher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:publish';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $topic = env('TOPIC_VA', null);
        $queue = env('QUEUE_VA', null);

        $message = [
            'account_source'        => 10024,
            'amount'                => 2400000,
            'account_destination'   => 674488,
            'remiter_name'          => ""
        ];

        event(new Publish(json_encode($message), $topic, $queue));

        $this->info('publish data: '.json_encode($message));

    }

}