<?php

namespace App\Http\Resources;

use App\Constants\OrderConstants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'status' => OrderConstants::getStatusLabels()[$this->status],
            'total' => $this->total,
            'items' => ItemResource::collection($this->items)
        ];
    }
}
