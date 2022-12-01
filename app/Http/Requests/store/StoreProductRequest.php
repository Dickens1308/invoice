<?php

namespace App\Http\Requests\store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $description
 * @property mixed $category_id
 * @property mixed $barcode
 * @property mixed $name
 * @property mixed $price
 * @property mixed $quantity
 * @property mixed $brand
 */
class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|gt:0',
            'price' => 'required|numeric|gt:0',
            'brand' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ];
    }
}
