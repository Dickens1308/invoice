<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $price
 * @property mixed $customer_id
 * @property mixed $product_id
 * @property mixed $invoice_id
 * @method static orderByDesc(string $string)
 * @method static where(string $string, mixed $id)
 */
class Order extends Model
{
    use HasFactory;

    public $fillable = [
        'price',
        'customer_id',
        'product_id',
        'invoice_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function Invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

}
