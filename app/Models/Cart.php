<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship với User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship với CartItem
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function themSanPham($productId, $quantity = 1)
    {
        $cartItem = $this->cartItems()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $this->cartItems()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        $this->touch();
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function capNhatSoLuong($productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->xoaSanPham($productId);
        }

        $this->cartItems()->where('product_id', $productId)->update(['quantity' => $quantity]);
        $this->touch();
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function xoaSanPham($productId)
    {
        $this->cartItems()->where('product_id', $productId)->delete();
        $this->touch();
    }

    /**
     * Tính tổng tiền giỏ hàng
     */
    public function getTongTienAttribute(): int
    {
        return $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    /**
     * Tính tổng số lượng sản phẩm
     */
    public function getTongSoLuongAttribute(): int
    {
        return $this->cartItems->sum('quantity');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function xoaToanBo()
    {
        $this->cartItems()->delete();
        $this->touch();
    }
}
