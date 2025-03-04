<?php

namespace App\Models;

use App\Services\OrderService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'status'
    ];

    protected $appends = ['total'];
    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->price;
        }
        return $total;
    }


    public function getItemIds()
    {
        $ids = [];
        foreach($this->items as $item)
        {
            $ids[] = $item->id;
        }
        return $ids;
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_order');
    }
    public function history()
    {
        return $this->hasMany(OrderHistory::class);
    }

}
