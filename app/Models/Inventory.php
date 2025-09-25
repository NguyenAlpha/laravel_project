<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';
    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'product_id',
        'quantity',
        'type',
        'reference'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'created_at' => 'datetime'
    ];

    /**
     * Relationship với Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Scope để lấy theo loại
     */
    public function scopeTheoLoai($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope để lấy nhập hàng
     */
    public function scopeNhapHang($query)
    {
        return $query->where('type', 'nhập hàng');
    }

    /**
     * Scope để lấy xuất hàng
     */
    public function scopeXuatHang($query)
    {
        return $query->where('type', 'xuất hàng');
    }

    /**
     * Scope để lấy điều chỉnh
     */
    public function scopeDieuChinh($query)
    {
        return $query->where('type', 'điều chỉnh');
    }

    /**
     * Scope để lấy theo sản phẩm
     */
    public function scopeTheoSanPham($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Tính tồn kho hiện tại của sản phẩm
     */
    public static function tonKhoHienTai($productId): int
    {
        $nhap = self::where('product_id', $productId)->nhapHang()->sum('quantity');
        $xuat = self::where('product_id', $productId)->xuatHang()->sum('quantity');

        return $nhap - $xuat;
    }
}
