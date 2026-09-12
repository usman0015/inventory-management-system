<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('item')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $items = Item::all();
        return view('orders.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed',
        ]);

        Order::create([
            'customer_name' => $request->customer_name,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function edit(Order $order)
    {
        $items = Item::all();
        return view('orders.edit', compact('order', 'items'));
    }

    public function update(Request $request, Order $order)
{
    $request->validate([
        'customer_name' => 'required',
        'item_id' => 'required|exists:items,id',
        'quantity' => 'required|integer|min:1',
        'status' => 'required|in:pending,completed',
    ]);

    $previousStatus = $order->status;
    $order->update($request->all());

    // If status changed from pending to completed
    if ($previousStatus === 'pending' && $request->status === 'completed') {
        $item = $order->item;
        if ($item->quantity >= $order->quantity) {
            $item->quantity -= $order->quantity;
            $item->save();
        }
    }

    return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
}

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}
