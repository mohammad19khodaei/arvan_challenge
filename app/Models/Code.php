<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Code extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'capacity', 'enable'];

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }

        
    /**
     * remove extra ( 10 percent ) extra winners
     *
     * @return Collection
     */
    public function removeExtraWinners(): Collection
    {
        $removedCount = $this->winners()->count() - $this->capacity;
        $toBeDeletedPhones = $this->winners()->orderByDesc('won_at')->limit($removedCount)->pluck('phone');
        Winner::whereIn('phone', $toBeDeletedPhones)->delete();
        return $toBeDeletedPhones;
    }
}
