<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show( String $id) {
        $products = Product::where('category', $id)
                      ->active()
                      ->paginate(20);
        return view('category.show', ['products' => $products]);
    }
}
