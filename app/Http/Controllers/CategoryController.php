<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show( String $category_id) {
        $products = Product::where('category_id', $category_id)
                      ->active()
                      ->paginate(20);
        return view('category.show', ['products' => $products]);
    }
}
