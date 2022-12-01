<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $id
 * @property mixed $invoice_no
 * @property mixed $total
 * @property mixed $sub_total
 * @property mixed $discount
 * @property mixed $items
 * @property mixed $tax
 * @method static orderByDesc(string $string)
 * @method static findorFail($id)
 */
class Invoice extends Model
{
    use HasFactory;

    public $fillable = [
        'invoice_no',
        'items',
        'tax',
        'discount',
        'sub_total',
        'total'
    ];

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
