<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function show( String $category_id) {
        $products = Product::where('category_id', $category_id)
                      ->active()
                      ->paginate(20);
        return view('frontend.category.show', ['products' => $products]);
    }
}
