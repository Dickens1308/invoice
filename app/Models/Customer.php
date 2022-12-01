<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static orderByDesc(string $string)
 * @method static findorFail(Customer $customer)
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $email
 * @property mixed $phone_number
 * @property mixed $home_address
 * @property mixed $gender
 */
class Customer extends Model
{
    use HasFactory;

    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone_number',
        'home_address'
    ];

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
