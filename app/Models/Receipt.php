<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Receipt extends Model
{
    use HasFactory;

    protected $table = 'receipt';
    protected $primaryKey = 'receipt_id';

    protected $fillable = [
        'supplier_id',
        'order_date',
        'status'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'status' => 'string'
    ];

    protected $attributes = [
        'status' => 'đang chờ'
    ];

    /**
     * Relationship với Supplier
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Relationship với ReceiptDetail
     */
    public function receiptDetails(): HasMany
    {
        return $this->hasMany(ReceiptDetail::class, 'receipt_id');
    }

    /**
     * Scope để lấy receipt theo status
     */
    public function scopeTheoStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope để lấy receipt đang chờ
     */
    public function scopeDangCho($query)
    {
        return $query->where('status', 'đang chờ');
    }

    /**
     * Scope để lấy receipt đã nhận
     */
    public function scopeDaNhan($query)
    {
        return $query->where('status', 'đã nhận');
    }

    /**
     * Tính tổng giá trị receipt
     */
    public function getTongTienAttribute(): int
    {
        return $this->receiptDetails->sum(function($detail) {
            return $detail->quantity * $detail->price;
        });
    }

    /**
     * Tính tổng số lượng sản phẩm
     */
    public function getTongSoLuongAttribute(): int
    {
        return $this->receiptDetails->sum('quantity');
    }
}