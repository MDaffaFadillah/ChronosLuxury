<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil kategori langsung dari database
        $categories = Category::all();

        // Mengambil 4 produk dengan flag featured teratas
        $featuredProducts = Product::where('featured', true)->take(4)->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}
