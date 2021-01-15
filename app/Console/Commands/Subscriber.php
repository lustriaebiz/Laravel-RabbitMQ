<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\Subscribe;

class Subscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:subscribe';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'subscribe data';

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
        $queue      = env('QUEUE_VA', null);
        $message    = Subscribe::consume($queue);

        $this->info('subcribe data: '.$message);
    }

}