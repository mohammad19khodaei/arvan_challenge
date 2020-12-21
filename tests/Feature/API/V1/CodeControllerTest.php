<?php

namespace Tests\Feature\API\V1;

use App\Models\Code;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Support\Str;

class CodeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function code_can_created()
    {
        $this->withoutExceptionHandling();
        $attributes = Code::factory()->raw();

        Redis::shouldReceive('set')
            ->once()
            ->with(
                $attributes['code'], 
                ceil($attributes['capacity']  + ($attributes['capacity'] * 0.1))
            );

        $response = $this->json('post', route('codes.store'), $attributes);

        $response->assertStatus(201);

        $this->assertDatabaseHas('codes', [
            'code' => $attributes['code'],
            'capacity' => $attributes['capacity'],
            'enable' => true
        ]);
    }

    /** @test */
    public function code_can_not_created_without_code_text()
    {
        $response = $this->json(
            'post',
            route('codes.store'),
            [
                'capacity' => mt_rand(10, 100)
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['code'])
            ->assertJson([
                'errors' => [
                    'code' => ['The code field is required.']
                ]
            ]);
    }

    /** @test */
    public function code_can_not_created_without_capacity()
    {
        $response = $this->json(
            'post',
            route('codes.store'),
            [
                'code' => Str::random(32),
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['capacity'])
            ->assertJson([
                'errors' => [
                    'capacity' => ['The capacity field is required.']
                ]
            ]);
    }

    /** @test */
    public function duplicate_code_can_not_created()
    {
        $code = Code::factory()->create();
        $response = $this->json(
            'post',
            route('codes.store'),
            [
                'code' => $code->code,
                'capacity' => $capacity = mt_rand(10, 10)
            ]
        );
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code'])
            ->assertJson([
                'errors' => [
                    'code' => ['The code has already been taken.']
                ]
            ]);

        $this->assertDatabaseMissing('codes', [
            'code' => $code->code,
            'capacity' => $capacity,
            'enable' => true,
        ]);
    }

    /** @test */
    public function code_can_not_be_less_than_3()
    {
        $response = $this->json(
            'post',
            route('codes.store'),
            [
                'code' => 'ab'
            ]
        );
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code'])
            ->assertJson([
                'errors' => [
                    'code' => ['The code must be at least 3 characters.']
                ]
            ]);
    }

    /** @test */
    public function code_can_not_be_more_than_32()
    {
        $response = $this->json(
            'post',
            route('codes.store'),
            [
                'code' => Str::random(33)
            ]
        );
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code'])
            ->assertJson([
                'errors' => [
                    'code' => ['The code may not be greater than 32 characters.']
                ]
            ]);
    }
}
