<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::with(['orderDetails.product'])->where('user_id', $user->user_id)->get();

        return view('frontend.order.index', compact('user', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:tiền mặt,chuyển khoản'
        ], [
            'address.required' => 'Vui lòng chọn địa chỉ giao hàng',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ'
        ]);
        $address = $request->input('address');
        $paymentMethod = $request->input('payment_method');

        $cart = Cart::with(['cartItems.product'])->where('user_id', Auth::id())->first();
        $totalAmount = $cart->getTongTienAttribute();


        Order::create([
            'user_id' => Auth::id(),
            'address' => $address,
            'total_amount' => $totalAmount,
            'payment_method' => $paymentMethod
        ]);

        return redirect()->route('order.index')->with('success', 'Đặt hàng thành công!');
    }

    public function show($id) {}

    public function cancel(Order $order)
    {
        $order->capNhatTrangThai('đã hủy');
        return redirect()->route('order.index')->with('success', 'Hủy đơn hàng thành công!');
    }

    public function delivered(Order $order)
    {
        $order->capNhatTrangThai('đã nhận hàng');
        return redirect()->route('order.index')->with('success', 'đơn hàng của bạn đã hoàn thành!');
    }
}
