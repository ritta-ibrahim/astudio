<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return Response::api(ItemResource::collection($items));
    }


    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $item = Item::create($data);
        return Response::api(new ItemResource($item));
    }

}
