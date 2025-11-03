<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order'; // Tên bảng đặc biệt, cần escape
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'address',
        'delivery_date',
        'total_amount',
        'status',
        'payment_method',
        'created_by'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'delivery_date' => 'datetime',
        'total_amount' => 'integer'
    ];

    protected $attributes = [
        'status' => 'chờ xác nhận'
    ];

    /**
     * Relationship với User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship với OrderDetail
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    /**
     * Scope để lấy order theo status
     */
    public function scopeTheoStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope để lấy order đang chờ xác nhận
     */
    public function scopeChoXacNhan($query)
    {
        return $query->where('status', 'chờ xác nhận');
    }

    /**
     * Scope để lấy order đã xác nhận
     */
    public function scopeDaXacNhan($query)
    {
        return $query->where('status', 'đã xác nhận');
    }

    /**
     * Scope để lấy order đang giao
     */
    public function scopeDangGiao($query)
    {
        return $query->where('status', 'đang giao');
    }

    /**
     * Scope để lấy order đã nhận
     */
    public function scopeDaNhan($query)
    {
        return $query->where('status', 'đã nhận hàng');
    }

    /**
     * Scope để lấy order đã hủy
     */
    public function scopeDaHuy($query)
    {
        return $query->where('status', 'đã hủy');
    }

    /**
     * Tính tổng số lượng sản phẩm
     */
    public function getTongSoLuongAttribute(): int
    {
        return $this->orderDetails->sum('quantity');
    }

    /**
     * Format tổng tiền
     */
    public function getTotalAmountFormattedAttribute(): string
    {
        return number_format($this->total_amount, 0, ',', '.') . 'đ';
    }

    /**
     * Kiểm tra có thể hủy đơn không
     */
    public function coTheHuy(): bool
    {
        return in_array($this->status, ['chờ xác nhận', 'đã xác nhận']);
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function capNhatTrangThai($status)
    {
        $this->update(['status' => $status]);

        if ($status === 'đã nhận hàng' && !$this->delivery_date) {
            $this->update(['delivery_date' => now()]);
        }
    }

    /**
     * Tính tổng tiền các đơn đã hoàn thành (đã nhận hàng)
     */
    public static function getTotalAmount($startDate = null, $endDate = null)
    {
        $query = self::daNhan();

        if ($startDate) {
            $query->whereDate('order_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('delivery_date', '<=', $endDate);
        }

        return $query->sum('total_amount');
    }

    public function getShippingStatusAttribute()
    {
        return $this->status === 'đang giao' ? 'Đang vận chuyển' : $this->status;
    }
}
