<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class MessageValidator
{
    protected string $code;

    protected ?string $phone;

    protected $isWinner = false;

    protected $isLastWinner = false;

    public function __construct(string $code, ?string $phone)
    {
        $this->code = $code;
        $this->phone = $phone;
    }

    public function validate(): self
    {
        if (!$this->isValidPhoneNumber()) {
            return $this;
        }

        $this->checkWinner();

        return $this;
    }

    protected function isValidPhoneNumber(): bool
    {
        if (empty($this->phone)) {
            return false;
        }

        return preg_match('/^09(1[0-9]|3[1-9]|2[1-9])-?[0-9]{3}-?[0-9]{4}$/', $this->phone);
    }

    protected function checkWinner()
    {
        /**
         * status will be a number if current phone is a winner
         * otherwise it will be false
         */
        $status = Redis::eval(<<<'LUA'
            local isWinner = redis.call("hget", "winners", KEYS[1])
            local remaining = redis.call("get", KEYS[2])
        
            if remaining > '0' and isWinner == false then
                remaining = redis.call("decr", KEYS[2])
                redis.call("hset", "winners", KEYS[1], KEYS[2])
                return remaining
            end
        
            return false
        LUA, 2, $this->phone, $this->code);

        if ($status !== false) {
            $this->isWinner = true;

            if ($status === 0) {
                $this->isLastWinner = true;
            }
        }
    }

    public function isWinner(): bool
    {
        return $this->isWinner;
    }

    public function isLastWinner(): bool
    {
        return $this->isLastWinner;
    }
}
