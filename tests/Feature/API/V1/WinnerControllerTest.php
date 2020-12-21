<?php

namespace Tests\Feature\API\V1;

use Tests\TestCase;
use App\Models\Winner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class WinnerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_list_of_winners_with_pagination()
    {
        $winners = Winner::factory()->count(5)->create();
        $winners = $winners->sortByDesc('won_at')->map(function ($winner) {
            $won_at = Carbon::createFromTimestamp((int)$winner->won_at/1000)->diffForHumans();
            $winner = $winner->only('id', 'phone', 'code');
            $winner['won_at'] = $won_at;
            return $winner;
        })->values()->toArray();        

        $response = $this->json('get', route('winners.index'));

        $response->assertOk()
                ->assertJson(['data' => $winners])
                ->assertJsonStructure([
                    'links' => [
                        'first', 'last', 'prev' ,'next'
                    ],
                    'meta' => [
                        'current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total'
                    ]
                ]);
    }

    /** @test */
    public function can_define_per_page_for_fetching_data()
    {
        Winner::factory()->count(15)->create();

        $response = $this->json(
            'get',
            route('winners.index'),
            [
                'per_page' => 15
            ]
        );
        $data = json_decode($response->getContent(), 1)['data'];

        $response->assertOk();
        $this->assertCount(15, $data);
    }

    /** @test */
    public function can_fetch_data_of_second_page_correctly()
    {
        Winner::factory()->count(11)->create();

        $response = $this->json(
            'get',
            route('winners.index'),
            [
                'per_page' => 10,
                'page' => 2
            ]
        );

        $data = json_decode($response->getContent(), 1)['data'];

        $response->assertOk();
            
        $this->assertCount(1, $data);
    }
}
