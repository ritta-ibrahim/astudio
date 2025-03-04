<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'changed_field',
        'old_value',
        'new_value'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
