<?php

namespace Tests\Feature\API\V1;

use Tests\TestCase;
use App\Models\Winner;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WinnerContrllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_list_of_winners()
    {
        $this->withoutExceptionHandling();
        $winners = Winner::factory()->count(5)->create();
        $winners = $winners->map(fn($winner) => $winner->only('phone', 'code'))->toArray();

        $response = $this->json('get', route('winners.index'));

        $response->assertOk()
                ->assertJson($winners);
    }
}
