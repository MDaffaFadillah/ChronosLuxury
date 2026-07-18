<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%");
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150|unique:products,name',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
            'reference_number' => 'required|string|max:50',
            'movement' => 'required|string|max:100',
            'case_material' => 'required|string|max:100',
            'dial_color' => 'required|string|max:50',
            'bracelet' => 'required|string|max:100',
            'power_reserve' => 'required|string|max:100',
            'water_resistance' => 'required|string|max:100',
            'case_diameter' => 'required|string|max:50',
            'condition' => 'required|string|max:100',
            'featured' => 'nullable|boolean'
        ]);

        $imagePath = 'assets/images/classic-oyster.png'; // Default fallback image

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            // Simpan gambar secara langsung ke public folder agar langsung terakses
            $image->move(public_path('assets/images'), $filename);
            $imagePath = 'assets/images/' . $filename;
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
            'reference_number' => $request->reference_number,
            'movement' => $request->movement,
            'case_material' => $request->case_material,
            'dial_color' => $request->dial_color,
            'bracelet' => $request->bracelet,
            'power_reserve' => $request->power_reserve,
            'water_resistance' => $request->water_resistance,
            'case_diameter' => $request->case_diameter,
            'condition' => $request->condition,
            'featured' => $request->has('featured') ? true : false,
        ]);

        return redirect()->route('products.index')->with('success', 'Boutique timepiece listed successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150|unique:products,name,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
            'reference_number' => 'required|string|max:50',
            'movement' => 'required|string|max:100',
            'case_material' => 'required|string|max:100',
            'dial_color' => 'required|string|max:50',
            'bracelet' => 'required|string|max:100',
            'power_reserve' => 'required|string|max:100',
            'water_resistance' => 'required|string|max:100',
            'case_diameter' => 'required|string|max:50',
            'condition' => 'required|string|max:100',
            'featured' => 'nullable|boolean'
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            // Hapus file lama jika ada dan bukan file dummy instan bawaan
            $oldFullPath = public_path($product->image);
            if (File::exists($oldFullPath) && !str_contains($product->image, 'diver-submariner') && !str_contains($product->image, 'chrono-daytona') && !str_contains($product->image, 'dress-datajust') && !str_contains($product->image, 'classic-oyster') && !str_contains($product->image, 'yatch-daytona')) {
                File::delete($oldFullPath);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images'), $filename);
            $imagePath = 'assets/images/' . $filename;
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
            'reference_number' => $request->reference_number,
            'movement' => $request->movement,
            'case_material' => $request->case_material,
            'dial_color' => $request->dial_color,
            'bracelet' => $request->bracelet,
            'power_reserve' => $request->power_reserve,
            'water_resistance' => $request->water_resistance,
            'case_diameter' => $request->case_diameter,
            'condition' => $request->condition,
            'featured' => $request->has('featured') ? true : false,
        ]);

        return redirect()->route('products.index')->with('success', 'Boutique timepiece updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Cegah penghapusan jika gambar terintegrasi bukan file dummy bawaan
        $fullPath = public_path($product->image);
        if (File::exists($fullPath) && !str_contains($product->image, 'diver-submariner') && !str_contains($product->image, 'chrono-daytona') && !str_contains($product->image, 'dress-datajust') && !str_contains($product->image, 'classic-oyster') && !str_contains($product->image, 'yatch-daytona')) {
            File::delete($fullPath);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Timepiece deleted successfully from boutique inventory.');
    }
}
