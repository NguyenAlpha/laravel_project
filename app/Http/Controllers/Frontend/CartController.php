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
        $cart = Cart::with(['cartItems.product'])->where('user_id', Auth::id())->first();
        $cart->themSanPham($productId, $quantity);
        return redirect()->route('cart.index');
    }

    public function buyNow(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = Cart::with(['cartItems.product'])->where('user_id', Auth::id())->first();

        $cart->themSanPham($productId, $quantity);

        return redirect()->route('cart.index');
    }

    public function store(Request $request) {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = Cart::with(['cartItems'])->where('user_id', Auth::id())->first();

        $cart->themSanPham($productId, $quantity);
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = Cart::with(['cartItems.product'])->where('user_id', Auth::id())->first();

        $cart->themSanPham($productId, $quantity);

        return redirect()->back()->with('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,product_id',
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

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
    public function deleteCartItem($productId)
    {
        $cart = Cart::where('user_id', Auth::id())->firstOrFail();

        $cart->xoaSanPham($productId);

        return redirect()->route('cart.index')->with('success', 'Xóa sản phẩm khỏi giỏ hàng thành công');
    }

    /**
     * Summary of checkout
     * @return \Illuminate\Contracts\View\View
     */
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
