<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static orderByDesc(string $string)
 * @method static findorFail(Supplier $customer)
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $email
 * @property mixed $phone_number
 * @property mixed $work_address
 */
class Supplier extends Model
{
    use HasFactory;

    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'work_address'
    ];
}
