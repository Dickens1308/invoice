<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed $id
 * @property mixed $product_id
 * @property mixed $customer_id
 * @property mixed $invoice_id
 * @property mixed $price
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
            'invoice_id' => $this->invoice_id,
        ];
    }
}
