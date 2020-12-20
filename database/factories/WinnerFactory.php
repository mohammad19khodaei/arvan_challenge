<?php

namespace Database\Factories;

use App\Models\Code;
use App\Models\Winner;
use Illuminate\Database\Eloquent\Factories\Factory;

class WinnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Winner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $code = Code::factory()->create();
        return [
            'phone' => '0912111223'. mt_rand(1,9),
            'code_id' => $code->id,
            'code' => $code->code,
            'won_at' => now()->subDays(mt_rand(1,20))->getPreciseTimestamp(3)
        ];
    }
}
