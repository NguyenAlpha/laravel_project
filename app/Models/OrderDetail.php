<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_detail';
    protected $primaryKey = 'order_detail_id';
    public $timestamps = false;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer'
    ];

    /**
     * Relationship với Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
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
        return $this->quantity * $this->price;
    }

    /**
     * Format thành tiền
     */
    public function getThanhTienFormattedAttribute(): string
    {
        return number_format($this->thanh_tien, 0, ',', '.') . 'đ';
    }

    /**
     * Format giá
     */
    public function getPriceFormattedAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }
}