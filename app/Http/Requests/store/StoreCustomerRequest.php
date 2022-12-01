<?php

namespace App\Http\Requests\store;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $email
 * @property mixed $phone_number
 * @property mixed $home_address
 * @property mixed $gender
 */
class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|string|max:255|in:male,female',
            'phone_number' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
        ];
    }
}
