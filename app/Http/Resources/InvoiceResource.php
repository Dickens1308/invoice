<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $invoice_no
 * @property mixed $total
 * @property mixed $sub_total
 * @property mixed $discount
 * @property mixed $items
 * @property mixed $tax
 * @property mixed $updated_at
 * @property mixed $created_at
 * @property mixed $orders
 */
class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'invoice_no' => $this->invoice_no,
            'items' => $this->items,
            'tax' => $this->tax,
            'discount' => $this->discount,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
