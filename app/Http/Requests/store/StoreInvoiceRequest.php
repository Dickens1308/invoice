<?php

namespace App\Http\Requests\store;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $orders
 */
class StoreInvoiceRequest extends FormRequest
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
            'invoice_no' => 'required|string|max:255',
            'items' => 'required|numeric|gt:0',
            'tax' => 'required|numeric|gte:0',
            'discount' => 'required|numeric|gte:0',
            'sub_total' => 'required|numeric|gt:0',
            'total' => 'required|numeric|gt:0',
            'orders' => 'required|array|min:1',
            'orders.*.price' => 'required|numeric',
            'orders.*.customer_id' => 'required|numeric|exists:customers,id',
            'orders.*.product_id' => 'required|exists:products,id',
        ];
    }
}
