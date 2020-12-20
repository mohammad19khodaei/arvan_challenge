<?php

namespace App\Console\Commands;

use App\Services\RabbitMQ;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConsumeTextMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:text_messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'consume text messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new RabbitMQ())->consume(function($msg) {
            echo $msg->body;
            echo PHP_EOL;
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        });
    }
}
