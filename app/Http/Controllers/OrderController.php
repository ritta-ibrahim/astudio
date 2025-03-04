<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\OrderService;
use App\Constants\OrderConstants;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return Response::api(OrderResource::collection($orders));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|exists:items,id',
        ]);

        $items = Item::whereIn('id', $data['items'])->get();

        $total = 0;
        foreach ($items as $item) {
            $total += $item->price;
        }

        $needApproval = $total >= OrderConstants::APPROVE_MIN;

        $order = Order::create([
            'status' => $needApproval ? OrderConstants::STATUS_WAITING : OrderConstants::STATUS_APPROVED,
            'number' => OrderService::generateOrderNumber(),
        ]);

        $order->items()->attach($data['items']);

        return Response::api(new OrderResource($order));

    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'items' => 'required|array|exists:items,id',
        ]);

        if ($order->status == OrderConstants::STATUS_APPROVED) {
            return Response::api(['message' => __('Order cannot be modified any more')], 403);
        }

        $items = Item::whereIn('id', $data['items'])->get();

        $total = 0;
        foreach ($items as $item) {
            $total += $item->price;
        }

        $needApproval = $total >= OrderConstants::APPROVE_MIN;

        $order->update([
            'status' => $needApproval ? OrderConstants::STATUS_WAITING : OrderConstants::STATUS_APPROVED,
        ]);

        $orderHistory = OrderHistory::create([
            'order_id' => $order->id,
            'changed_field' => 'items',
            'old_value' => json_encode($order->getItemIds()),
            'new_value' => json_encode($data['items'])
        ]);

        $order->items()->sync($data['items']);

        return Response::api(new OrderResource($order));

    }

    public function approve(Order $order)
    {
        $order->status = OrderConstants::STATUS_APPROVED;
        $order->save();
        return Response::api(['message' => __('Order Approved'), 'order' => $order]);
    }
    public function check(Order $order)
    {
        return Response::api(['status' => OrderConstants::getStatusLabels()[$order->status]]);
    }
    public function show(Order $order)
    {
        return Response::api(new OrderResource($order));
    }

    public function history(Order $order)
    {
        $history = $order->history;
        return Response::api($history);
    }
}
