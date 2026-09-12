<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function generate(Request $request)
    {
        $itemName = $request->input('name');

        if (!$itemName) {
            return response()->json(['error' => 'Item name is required.'], 400);
        }

        $fakeDescription = "Introducing our premium $itemName — crafted for comfort, durability, and style. Perfect for everyday wear and designed to elevate your look.";

        return response()->json(['description' => $fakeDescription]);
    }
}
