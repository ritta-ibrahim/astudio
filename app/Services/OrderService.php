<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderService
{
    public static function generateOrderNumber()
    {
        $latestOrder = Order::latest()->first();

        $nextNumber = $latestOrder ? $latestOrder->id +1 : 1;

        return 'ORD-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
