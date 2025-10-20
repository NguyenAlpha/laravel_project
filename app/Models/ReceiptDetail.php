<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceiptDetail extends Model
{
    use HasFactory;

    protected $table = 'receipt_detail';
    protected $primaryKey = 'receipt_detail_id';
    public $timestamps = false;
    protected $fillable = [
        'receipt_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer'
    ];

    /**
     * Relationship với Receipt
     */
    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class, 'receipt_id');
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
     * Format giá thành tiền
     */
    public function getThanhTienFormattedAttribute(): string
    {
        return number_format($this->thanh_tien, 0, ',', '.') . 'đ';
    }
}
