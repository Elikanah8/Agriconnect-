<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // --- CREATE/STORE LOGIC ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string', // Added validation
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category, // Added this line
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Product listed successfully!');
    }

    // --- EDIT LOGIC ---
    public function edit(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403, 'Unauthorized access');
        }

        return view('products.edit', compact('product'));
    }

    // --- UPDATE LOGIC ---
    public function update(Request $request, Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string', // Added validation
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Included category in the allowed update fields
        $data = $request->only(['name', 'category', 'description', 'price', 'quantity']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('dashboard')->with('success', 'Product updated successfully!');
    }

    // --- DELETE LOGIC ---
    public function destroy(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product deleted.');
    }
}