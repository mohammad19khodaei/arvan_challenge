<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\StoreCodeRequest;
use App\Models\Code;
use Illuminate\Support\Facades\Redis;

class CodeController
{
    public function __invoke(StoreCodeRequest $request)
    {
        Code::query()->create($request->validated());

        // add 10 percent more capacity for possible fault
        $capacity = $request->capacity;
        $capacity = (int)ceil($capacity + ($capacity * 0.1));

        Redis::set($request->code, $capacity);

        return response()->json([
            'message' => 'Code added successfully'
        ], 201);
    }
}
