<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class categorycontroller extends Controller
{
    public function index(){
        $categories = category::get(); // Fetch all categories
        return view('categories.index', compact('categories')); // Pass the correct variable name
    }


    public function create(){
        return redirect()->route('categories.index')->with('status', 'Category created');
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'required|max:255|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
    }

    Category::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'image' => $imagePath,
    ]);

    return redirect('categories')->with('status', 'Category created successfully');
}

    public function edit(int $id){
        $category = category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, int $id){
        $request->validate([
            'name'=> 'required|max:255',
            'description' => 'required|max:255|string',
            'price'=> 'required|max:255',
            'quantity'=> 'required|max:255',
        ]);
        category::findOrFail($id)->update([
            'name'=> $request->name,
            'description'=> $request->description,
            'price'=> $request->price,
            'quantity'=> $request->quantity
            ]);
            return redirect()->back()->with('status','Category Update');
    }
    public function destroy(int $id){

        $category = category::findOrFail($id);
        $category ->delete();

        return redirect()->back()->with('status','Category Deleted');
    }
    public function view()
{

    $categories = category::all();


    return view('categories.view', compact('categories'));
}
public function buy(Request $request, $id)
{
    $category = Category::findOrFail($id);
    $newQuantity = $request->input('quantity');

    if ($newQuantity >= 0) {
        $category->quantity = $newQuantity;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Quantity updated']);
    } else {
        return response()->json(['success' => false, 'message' => 'Quantity cannot be negative']);
    }
}


}
