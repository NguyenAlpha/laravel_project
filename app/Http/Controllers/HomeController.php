<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {

        $categories = Category::with(['products' => function ($query) {
            $query->active()->limit(30);
        }])->get();


        /**
         * phương thức ->pluck() được sử dụng để lấy ra một mảng các giá trị
         * từ một cột cụ thể trong collection hoặc kết quả query.
         * ->pluck('column_name')
         * nhưng ở đây thì khác:
         * ở đây trả về collection của collections products
         *
         * [
         *       Collection([ProductA, ProductB]),  products của category 1
         *       Collection([ProductC, ProductD, ProductE]) products của category 2
         * ]
         * ->flatten() làm "phẳng" nested collections thành một collection duy nhất:
         * Collection([ProductA, ProductB, ProductC, ProductD, ProductE])
         */
        $products = $categories->pluck('products')->flatten();

        // $bestSellingProducts = Product::where('status', 'hiện')
        //     ->orderBy('DaBan', 'DESC')
        //     ->limit(25)~
        //     ->get();

        return view('home.index', [
            'products' => $products,
            'categories' => $categories
        ]);

        // return view('frontend.home.index', [
        //     'products' => $products,
        //     'categories' => $categories,
        //     'bestSellingProducts' => $bestSellingProducts,
        // ]);
    }
}
