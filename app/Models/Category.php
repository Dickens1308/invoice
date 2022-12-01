<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderByDesc(string $string)
 * @method static findorFail($id)
 * @property mixed $name
 */
class Category extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
