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



        // phương thức ->pluck() được sử dụng để lấy ra một mảng các giá trị
        // từ một cột cụ thể trong collection hoặc kết quả query.
        // ->pluck('column_name')
        // nhưng ở đây thì khác:
        // ở đây trả về collection của collections products
        // 
        // [
        //       Collection([ProductA, ProductB]),  products của category 1
        //       Collection([ProductC, ProductD, ProductE]) products của category 2
        // ]
        // ->flatten() làm "phẳng" nested collections thành một collection duy nhất:
        // Collection([ProductA, ProductB, ProductC, ProductD, ProductE])

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

    public function search(Request $request)
    {
        $textSearch = $request->input('search');

        // Nếu có tìm kiếm
        if ($textSearch) {
            $products = Product::with(['category', 'laptopDetail', 'screenDetail', 'gpuDetail', 'headsetDetail', 'mouseDetail', 'keyboardDetail'])
                ->active()
                ->where(function ($query) use ($textSearch) {
                    $query->where('product_name', 'LIKE', "%{$textSearch}%")
                        ->orWhereHas('category', function ($q) use ($textSearch) {
                            $q->where('category_name', 'LIKE', "%{$textSearch}%");
                        })
                        ->orWhereHas('laptopDetail', function ($q) use ($textSearch) {
                            $q->where('thuong_hieu', 'LIKE', "%{$textSearch}%")
                                ->orWhere('cpu', 'LIKE', "%{$textSearch}%")
                                ->orWhere('ram', 'LIKE', "%{$textSearch}%");
                        })
                        ->orWhereHas('screenDetail', function ($q) use ($textSearch) {
                            $q->where('thuong_hieu', 'LIKE', "%{$textSearch}%")
                                ->orWhere('kich_thuoc_man_hinh', 'LIKE', "%{$textSearch}%")
                                ->orWhere('do_phan_giai', 'LIKE', "%{$textSearch}%");
                        })
                        ->orWhereHas('gpuDetail', function ($q) use ($textSearch) {
                            $q->where('thuong_hieu', 'LIKE', "%{$textSearch}%")
                                ->orWhere('gpu', 'LIKE', "%{$textSearch}%");
                        })
                        ->orWhereHas('headsetDetail', function ($q) use ($textSearch) {
                            $q->where('thuong_hieu', 'LIKE', "%{$textSearch}%")
                                ->orWhere('ket_noi', 'LIKE', "%{$textSearch}%");
                        })
                        ->orWhereHas('mouseDetail', function ($q) use ($textSearch) {
                            $q->where('thuong_hieu', 'LIKE', "%{$textSearch}%")
                                ->orWhere('ket_noi', 'LIKE', "%{$textSearch}%");
                        })
                        ->orWhereHas('keyboardDetail', function ($q) use ($textSearch) {
                            $q->where('thuong_hieu', 'LIKE', "%{$textSearch}%")
                                ->orWhere('ket_noi', 'LIKE', "%{$textSearch}%");
                        });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20)
                ->appends(['search' => $textSearch]);

            $categories = Category::all();

            return view('search.index', compact('products', 'categories', 'textSearch'));
        }

        // Nếu không có tìm kiếm, hiển thị trang chủ bình thường
        $categories = Category::with(['products' => function ($query) {
            $query->active()->limit(30);
        }])->get();

        $products = $categories->pluck('products')->flatten();

        return view('home.index', compact('products', 'categories', 'textSearch'));
    }
}
