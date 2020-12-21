<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Winner;
use App\Http\Resources\WinnerResource;

class WinnerContoller
{
    public function __invoke()
    {
        return WinnerResource::collection(Winner::query()->paginate(request('per_page', 10)));
    }
}
