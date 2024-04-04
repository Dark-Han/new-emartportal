<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index()
    {
        return Shop::all();
    }

    public function store(ShopRequest $request)
    {
        return Shop::create($request->validated());
    }

    public function show(Shop $shop)
    {
        return $shop;
    }

    public function update(ShopRequest $request, Shop $shop)
    {
        $shop->update($request->validated());

        return $shop;
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();

        return response()->json();
    }
}
