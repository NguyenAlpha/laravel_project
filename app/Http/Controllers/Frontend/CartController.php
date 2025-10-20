<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Vui lòng đăng nhập để xem giỏ hàng');
        }

        $user = Auth::user();
        $cart = Cart::with(['cartItems.product'])->where('user_id', Auth::id())->first();

        // Nếu chưa có giỏ hàng, tạo mới
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
            $cart->load('cartItems.product');
        }

        return view('frontend.cart.index', compact('cart'));
    }

    public function addCart(String $productId, int $quantity)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Đăng nhập để thêm sản phẩm vào giỏ hàng');
        }

        $cart = Cart::with(['cartItems.product'])->where('user_id', Auth::id())->first();
        $cart->themSanPham($productId, $quantity);
        return redirect()->route('cart.index');
    }

    public function buyNow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Đăng nhập để thêm sản phẩm vào giỏ hàng');
        }

        $userId = Auth::id();

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = Cart::with(['cartItems.product'])->where('user_id', $userId)->first();

        $cart->themSanPham($productId, $quantity);

        return redirect()->route('cart.index');
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Đăng nhập để thêm sản phẩm vào giỏ hàng');
        }

        $userId = Auth::id();

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = Cart::with(['cartItems.product'])->where('user_id', $userId)->first();

        $cart->themSanPham($productId, $quantity);

        return redirect()->back()->with('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function updateQuantity(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:product,product_id',
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cart = Cart::where('user_id', Auth::id())->firstOrFail();

            $product = Product::findOrFail($request->product_id);

            // Kiểm tra tồn kho nếu số lượng > 0
            if ($request->quantity > 0 && $product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng sản phẩm trong kho không đủ'
                ], 400);
            }

            $cart->capNhatSoLuong($request->product_id, $request->quantity);

            // Lấy lại thông tin mới nhất
            $cart->load('cartItems.product');
            $cartItem = $cart->cartItems->where('product_id', $request->product_id)->first();

            DB::commit();

            $response = [
                'success' => true,
                'message' => 'Cập nhật số lượng thành công',
                'cart_total' => $cart->tong_so_luong,
                'cart_amount' => $cart->tong_tien
            ];

            if ($cartItem) {
                $response['item_total'] = $cartItem->thanh_tien;
                $response['item_total_formatted'] = $cartItem->thanh_tien_formatted;
            }

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeFromCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:product,product_id'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cart = Cart::where('user_id', Auth::id())->firstOrFail();

            $cart->xoaSanPham($request->product_id);

            // Lấy lại thông tin mới nhất
            $cart->load('cartItems.product');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công',
                'cart_total' => $cart->tong_so_luong,
                'cart_amount' => $cart->tong_tien
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clearCart()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ], 401);
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cart = Cart::where('user_id', Auth::id())->firstOrFail();

            $cart->xoaToanBo();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Xóa toàn bộ giỏ hàng thành công',
                'cart_total' => 0,
                'cart_amount' => 0
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin giỏ hàng (API)
     */
    public function getCartInfo()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ], 401);
        }

        $user = Auth::user();
        $cart = Cart::with(['cartItems.product'])->where('user_id', Auth::id())->first();

        if (!$cart) {
            return response()->json([
                'success' => true,
                'cart_total' => 0,
                'cart_amount' => 0,
                'items' => []
            ]);
        }

        $items = $cart->cartItems->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->image,
                'price' => $item->product->price,
                'price_formatted' => number_format($item->product->price, 0, ',', '.') . 'đ',
                'quantity' => $item->quantity,
                'item_total' => $item->thanh_tien,
                'item_total_formatted' => $item->thanh_tien_formatted
            ];
        });

        return response()->json([
            'success' => true,
            'cart_total' => $cart->tong_so_luong,
            'cart_amount' => $cart->tong_tien,
            'cart_amount_formatted' => number_format($cart->tong_tien, 0, ',', '.') . 'đ',
            'items' => $items
        ]);
    }

    public function checkout()
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', Auth::id())
            ->latest()
            ->get();
        $cart = Cart::with(['cartItems.product'])->where('user_id', Auth::id())->first();
        $tongTienGioHang = $cart->getTongTienAttribute();
        return view('frontend.checkout.index', compact('user', 'cart', 'addresses', 'tongTienGioHang'));
    }
}
