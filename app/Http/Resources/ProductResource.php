<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed $id
 * @property mixed $barcode
 * @property mixed $name
 * @property mixed $quantity
 * @property mixed $brand
 * @property mixed $created_at
 * @property mixed $description
 * @property mixed $price
 * @property mixed $updated_at
 * @property mixed $category_id
 */
class ProductResource extends JsonResource
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
            'barcode' => $this->barcode,
            'name' => $this->name,
            'brand' => $this->brand,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => new CategoryResource(Category::findorFail($this->category_id)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
