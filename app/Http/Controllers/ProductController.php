<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductFilterService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show()
    {
        return view('product.show');
    }

    /*
        Hàm hiển thị sản phẩm theo danh mục có filter và phân trang
    */
    /*
    public function indexByCategory(Category $category, Request $request)
    {
        // 1. Lấy filters config
        $filters = ProductFilterService::getFiltersForCategory($category->category_id);

        // 2. Khởi tạo query
        $products = Product::with(['category', 'laptopDetail', 'screenDetail'])
            ->where('category_id', $category->category_id)
            ->active();

        // 3. Áp dụng filters (ĐÃ BAO GỒM where category_id bên trong)
        $products = ProductFilterService::applyFilters($products, $request, $category->category_id);

        // 4. Thực thi query
        $products = $products->paginate(12);


        return view('product.index', compact('products', 'category', 'filters'));
    }*/

    public function indexByCategory(Category $category, Request $request)
    {
        // 1. Lấy filters config
        $filters = ProductFilterService::getFiltersForCategory($category->category_id);

        // 2. Khởi tạo query
        /**
         * ::with() eager loading tránh N+1 query problem
         */
        $products = Product::with(['category', 'laptopDetail', 'screenDetail', 'laptopGamingDetail', 'gpuDetail', 'headsetDetail', 'mouseDetail', 'keyboardDetail'])
            ->where('category_id', $category->category_id)
            ->active();

        // 3. Áp dụng filters (thuộc tính detail + giá)
        $products = $this->applyCustomFilters($products, $request, $filters, $category->category_id);

        // 4. Thực thi query
        /**
         * ->paginate(12) để phân trang, mỗi trang 12 sản phẩm
         * ->appends($request->query() có tác dụng giữ lại các tham số filter khi phân trang
         * Khi KHÔNG có appends(): Khi click trang 2 sẽ mất hết filter
         * Khi CÓ appends(): Khi click trang 2 sẽ còn filter
         */
        $products = $products->paginate(12)->appends($request->query());

        return view('product.index', compact('products', 'category', 'filters'));
    }

    /**
     * Áp dụng custom filters (thuộc tính detail + khoảng giá)
     */
    private function applyCustomFilters($query, $request, $filters, $categoryId)
    {
        // A. FILTER THUỘC TÍNH CHI TIẾT (từ bảng detail)
        foreach ($filters as $attribute => $filter) {
            if ($request->filled($attribute)) {
                $selectedValues = (array) $request->input($attribute);

                if (!empty($selectedValues)) {
                    $relation = $this->getRelationByCategoryId($categoryId);

                    if ($relation) {
                        $query->whereHas($relation, function ($q) use ($attribute, $selectedValues) {
                            $q->whereIn($attribute, $selectedValues);
                        });
                    }
                }
            }
        }

        // B. FILTER KHOẢNG GIÁ (từ bảng product)
        $this->applyPriceFilter($query, $request);

        // C. FILTER SẮP XẾP THEO GIÁ
        $this->applySorting($query, $request);

        return $query;
    }

    /**
     * Filter theo khoảng giá
     */
    private function applyPriceFilter($query, $request)
    {
        // Filter theo khoảng giá nhập tay
        if ($request->filled('giaThap') || $request->filled('giaCao')) {
            $minPrice = (int) $request->input('giaThap', 0);
            $maxPrice = (int) $request->input('giaCao', 0);

            // Đảm bảo minPrice <= maxPrice
            if ($minPrice > 0 && $maxPrice > 0 && $minPrice <= $maxPrice) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            } elseif ($minPrice > 0) {
                $query->where('price', '>=', $minPrice);
            } elseif ($maxPrice > 0) {
                $query->where('price', '<=', $maxPrice);
            }
        }

        return $query;
    }

    /**
     * Sắp xếp sản phẩm
     */
    private function applySorting($query, $request)
    {
        $sortBy = $request->input('sapXep', 'mac-dinh');

        switch ($sortBy) {
            case 'gia-thap-den-cao':
                $query->orderBy('price', 'asc');
                break;
            case 'gia-cao-den-thap':
                $query->orderBy('price', 'desc');
                break;
            case 'moi-nhat':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                // $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }

    /**
     * Xác định relation name dựa trên attribute
     */
    private function getRelationByCategoryId($categoryId)
    {
        if ($categoryId == 'Laptop') {
            return 'laptopDetail';
        }

        if ($categoryId == 'ManHinh') {
            return 'screenDetail';
        }

        if ($categoryId == 'LaptopGaming') {
            return 'laptopGamingDetail';
        }

        if ($categoryId == 'GPU') {
            return 'gpuDetail';
        }

        if ($categoryId == 'Headset') {
            return 'headsetDetail';
        }

        if ($categoryId == 'Mouse') {
            return 'mouseDetail';
        }

        if ($categoryId == 'Keyboard') {
            return 'keyboardDetail';
        }
        return null;
    }
}
