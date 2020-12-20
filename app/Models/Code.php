<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'capacity', 'enable'];

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}
