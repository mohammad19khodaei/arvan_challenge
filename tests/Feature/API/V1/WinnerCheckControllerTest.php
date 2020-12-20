<?php

namespace Tests\Feature\API\V1;

use App\Models\Winner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WinnerCheckControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function phone_is_required_for_checking()
    {
        $response = $this->json(
            'get',
            route('winners.check'),
            [
                'phone' => ''
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone'])
            ->assertJson([
                'errors' => [
                    'phone' => ['The phone field is required.']
                ]
            ]);
    }

    /** @test */
    public function phone_must_have_correct_format()
    {
        $response = $this->json(
            'get',
            route('winners.check'),
            [
                'phone' => 'invalid'
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone'])
            ->assertJson([
                'errors' => [
                    'phone' => ['The phone format is invalid.']
                ]
            ]);
    }
     
    /** @test */
    public function return_successful_message_if_input_phone_is_a_winner()
    {
        $winner = Winner::factory()->create();
        $response = $this->json(
            'get',
            route('winners.check'),
            [
                'phone' => $winner->phone
            ]
        );

        $response->assertOk()
            ->assertJson([
                'message' => 'Congratulation! You are a winner'
            ]);
    }

    /** @test */
    public function return_unsuccessful_message_if_input_phone_is_not_a_winner()
    {
        $winner = Winner::factory()->create();
        $response = $this->json(
            'get',
            route('winners.check'),
            [
                'phone' => '09124442200'
            ]
        );

        $response->assertOk()
            ->assertJson([
                'message' => 'Sorry! You are not a winner'
            ]);
    }
}