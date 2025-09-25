<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    /**
     * Tên bảng trong database
     */
    protected $table = 'user';

    /**
     * Khóa chính của bảng
     */
    protected $primaryKey = 'user_id';

    /**
     * Khóa chính tự tăng
     */
    public $incrementing = true;

    /**
     * Kiểu khóa chính
     */
    protected $keyType = 'int';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'role',
        'sex',
        'phone_number',
        'dob',
        'status',
        'avatar_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relationship với Address
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    /**
     * Relationship với Cart
     */
    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }

    /**
     * Relationship với Order
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Scope để lấy user theo role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope để lấy user active
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'mở');
    }

    /**
     * Scope để lấy user bị khóa
     */
    public function scopeLocked($query)
    {
        return $query->where('status', 'khóa');
    }

    /**
     * Scope để lấy user đã xóa
     */
    public function scopeDeleted($query)
    {
        return $query->where('status', 'đã xóa');
    }

    /**
     * Kiểm tra user có phải admin không
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Kiểm tra user có phải customer không
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Kiểm tra user có active không
     */
    public function isActive(): bool
    {
        return $this->status === 'mở';
    }

    /**
     * Kiểm tra user có bị khóa không
     */
    public function isLocked(): bool
    {
        return $this->status === 'khóa';
    }

    /**
     * Kiểm tra user có bị xóa không
     */
    public function isSoftDeleted(): bool
    {
        return $this->status === 'đã xóa';
    }

    /**
     * Lấy địa chỉ mặc định
     */
    public function getDiaChiMacDinhAttribute()
    {
        return $this->addresses()->macDinh()->first();
    }

    /**
     * Tạo giỏ hàng nếu chưa có
     */
    public function getOrCreateCart()
    {
        if (!$this->cart) {
            $this->cart()->create();
            $this->load('cart');
        }

        return $this->cart;
    }
}
