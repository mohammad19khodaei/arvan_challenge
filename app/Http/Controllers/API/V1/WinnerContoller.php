<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Winner;

class WinnerContoller
{
    public function __invoke()
    {
        $winners = Winner::query()->select('code', 'phone')->get();
        return response()->json($winners);
    }
}
