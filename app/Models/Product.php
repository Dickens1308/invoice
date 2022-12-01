<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderByDesc(string $string)
 * @method static findorFail($id)
 * @property mixed $name
 * @property mixed $price
 * @property mixed $quantity
 * @property mixed $brand
 * @property mixed $description
 * @property mixed $category_id
 * @property mixed $barcode
 */
class Product extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'barcode',
        'price',
        'quantity',
        'brand',
        'description',
        'category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
