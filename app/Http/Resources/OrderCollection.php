<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->id,
            'product_name' => $this->product->name,
            'selling_price' => $this->product->price,
            'quantity' => $this->quantity,
            'tax_rate' => $this->tax->value,
            'total_amount' => $this->total_amount,
            'order_at' => Carbon::parse($this->updated_at)->toFormattedDateString(),
        ];
    }
}
