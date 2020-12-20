<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\CheckWinnerRequest;
use App\Models\Winner;

class WinnerCheckController
{
    public function __invoke(CheckWinnerRequest $request)
    {
        $isWinner = Winner::query()->wherePhone($request->phone)->exists();

        if($isWinner) {
            return response()->json([
                'message' => 'Congratulation! You are a winner'
            ]);
        }

        return response()->json([
            'message' => 'Sorry! You are not a winner'
        ]);
    }
}
