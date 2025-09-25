<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $primaryKey = 'address_id';

    protected $fillable = [
        'user_id',
        'address'
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
     * Scope để lấy địa chỉ mặc định (nếu có logic mặc định)
     */
    public function scopeMacDinh($query)
    {
        // Giả sử địa chỉ đầu tiên là mặc định
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * Kiểm tra xem địa chỉ có đang được sử dụng trong order không
     */
    public function dangDuocSuDung(): bool
    {
        return Order::where('address', $this->address)->exists();
    }
}