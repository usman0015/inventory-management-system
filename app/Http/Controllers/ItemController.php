<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $search = $request->input('search');

    $items = Item::when($search, function ($query, $search) {
        $query->where('name', 'like', "%{$search}%");
    })->orderBy('id','asc')->get();

    return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
      'name' => 'required',
    'category' => 'required|string|max:255',
    'quantity' => 'required|integer',
    'price' => 'required|numeric',
    'description' => 'nullable|string',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $data=$request->all();
        if($request->hasFile('image')){
            $imagePath=$request->file('image')->store('items','public');
            $data['image']=$imagePath;
        }
        Item::create($data);
        return redirect()->route('items.index')->with('success','items created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
            return view('items.edit', compact('item'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
           'name' => 'required',
    'category' => 'required|string|max:255',  
        'quantity' => 'required|integer',
    'price' => 'required|numeric',
    'description' => 'nullable|string',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $data=$request->all();
        if($request->hasFile('image')){
            $imagePath=$request->file('image')->store('items','public');
            $data['image']=$imagePath;
        }
        $item->update($data);
        return redirect()->route('items.index')->with('success','Item updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

    return redirect()->route('items.index')
                     ->with('success','Item deleted successfully.');
    }
}
