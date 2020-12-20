<?php

namespace App\Console\Commands;

use App\Models\Code;
use App\Services\MessageValidator;
use App\Services\RabbitMQ;
use Illuminate\Console\Command;

class ConsumeTextMessagesCommand extends Command
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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new RabbitMQ())->consume(function ($msg) {
            $parameters = json_decode($msg->body, 1);
            $codeText = $parameters['code'];
            $phone = $parameters['phone'];

            $validationResult = (new MessageValidator($codeText, $phone))
                ->validate();

            if (!$validationResult->isWinner()) {
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                return;
            }

            echo "winner";
            echo PHP_EOL;
            $code = Code::query()->whereCode($codeText)->firstOrFail();

            if (!$code->enable) {
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                return;
            }

            $timestamp = $parameters['timestamp'];
            $code->winners()->create([
                'phone' => $phone,
                'code' => $codeText,
                'won_at' => $timestamp,
            ]);

            if ($validationResult->isLastWinner()) {
                $code->update([
                    'enable' => false,
                ]);

                $removedCount = $code->winners()->count() - $code->capacity;
                $code->winners()->orderByDesc('won_at')->limit($removedCount)->delete();
            }


            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        });
    }
}
