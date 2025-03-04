<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Order;
use App\Services\OrderService;
use App\Constants\OrderConstants;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_unique_sequential_order_numbers_in_api()
    {
        $item1 = Item::create(['name' => 'item1', 'price' => 700]);
        $item2 = Item::create(['name' => 'item2', 'price' => 600]);
        $item3 = Item::create(['name' => 'item3', 'price' => 900]);
        $item4 = Item::create(['name' => 'item4', 'price' => 200]);

        $order1 = $this->postJson('/api/orders/create', [
            'items' => [$item1->id, $item2->id]
        ])['data'];
        $order2 = $this->postJson('/api/orders/create', [
            'items' => [$item1->id, $item2->id, $item3->id, $item4->id]
        ])['data'];

        $this->assertNotEquals($order1['number'], $order2['number']);
        $this->assertEquals('ORD-000001', $order1['number']);
        $this->assertEquals('ORD-000002', $order2['number']);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/orders/create', []);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_prevents_modification_of_approved_orders()
    {
        $item1 = Item::create(['name' => 'item1', 'price' => 2600]);
        $item2 = Item::create(['name' => 'item2', 'price' => 600]);

        $order = $this->postJson('/api/orders/create', [
            'items' => [$item1->id, $item2->id]
        ])['data'];

        $response = $this->postJson('/api/orders/' . $order['id'] . '/update', [
            'items' => [$item1->id, $item2->id]
        ]);

        $response->assertStatus(405);
    }

    /** @test */
    public function it_correctly_calculates_order_total()
    {

        $item1 = Item::create(['name' => 'item1', 'price' => 2600]);
        $item2 = Item::create(['name' => 'item2', 'price' => 600]);
        $item3 = Item::create(['name' => 'item3', 'price' => 300]);

        $order = $this->postJson('/api/orders/create', [
            'items' => [$item1->id, $item2->id, $item3->id]
        ])['data'];


        $orderModel = Order::find($order['id']);

        $orderModel->items()->sync([$item1->id, $item2->id, $item3->id]);

        $this->assertEquals(3500, $orderModel->total);
    }

}
