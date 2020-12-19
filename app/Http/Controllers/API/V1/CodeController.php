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

        Redis::set($request->code, $request->capacity);

        return response()->json([
            'message' => 'Code added successfully'
        ]);
    }
}
