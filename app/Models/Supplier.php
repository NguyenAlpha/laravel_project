<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'supplier_phone',
        'supplier_address'
    ];

    /**
     * Relationship với Receipt
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, 'supplier_id');
    }

    /**
     * Accessor để định dạng số điện thoại
     */
    /*
    public function getFormattedPhoneAttribute(): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1 $2 $3', $this->supplier_phone);
    }
    */
}
