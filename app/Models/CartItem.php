<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_item';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    /**
     * Relationship với Cart
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    /**
     * Relationship với Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Tính thành tiền
     */
    public function getThanhTienAttribute(): int
    {
        return $this->quantity * $this->product->price;
    }

    /**
     * Format thành tiền
     */
    public function getThanhTienFormattedAttribute(): string
    {
        return number_format($this->thanh_tien, 0, ',', '.') . 'đ';
    }

    /**
     * Kiểm tra số lượng có hợp lệ không
     */
    public function kiemTraSoLuong(): bool
    {
        return $this->quantity > 0 && $this->quantity <= $this->product->stock;
    }
}