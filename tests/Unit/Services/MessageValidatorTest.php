<?php

namespace Tests\Unit\Services;

use App\Services\MessageValidator;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\TestCase;

class MessageValidatorTest extends TestCase
{
    /** @test */
    public function it_can_do_validation_when_phone_is_empty()
    {
        $validationResult = (new MessageValidator('abc', null))
                ->validate();

        $this->assertFalse($validationResult->isWinner());
        $this->assertFalse($validationResult->isLastWinner());
    }

    /** @test */
    public function it_can_do_validation_when_phone_is_not_valid()
    {
        $validationResult = (new MessageValidator('abc', 'invalid'))
                ->validate();
        $this->assertFalse($validationResult->isWinner());
        $this->assertFalse($validationResult->isLastWinner());
    }

    /** @test */
    public function it_can_do_validation_when_phone_is_not_winner()
    {
        Redis::shouldReceive('eval')
            ->once()
            ->andReturn(false);

        $validationResult = (new MessageValidator('abc', '09121112233'))
                ->validate();

        $this->assertFalse($validationResult->isWinner());
        $this->assertFalse($validationResult->isLastWinner());
    }

    /** @test */
    public function it_can_do_validation_when_phone_is_winner()
    {
        Redis::shouldReceive('eval')
            ->once()
            ->andReturn(rand(1,100));

        $validationResult = (new MessageValidator('abc', '09121112233'))
                ->validate();

        $this->assertTrue($validationResult->isWinner());
        $this->assertFalse($validationResult->isLastWinner());
    }


    /** @test */
    public function it_can_do_validation_when_phone_is_last_winner()
    {
        Redis::shouldReceive('eval')
            ->once()
            ->andReturn(0);

        $validationResult = (new MessageValidator('abc', '09121112233'))
                ->validate();

        $this->assertTrue($validationResult->isWinner());
        $this->assertTrue($validationResult->isLastWinner());
    }
}
