<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    public static $categoryMapping = [
    'Laptop' => [
      'model' => LaptopDetail::class,
      'type' => 'Laptop'
    ],
    'Screen' => [
      'model' => ScreenDetail::class,
      'type' => 'Screen'
    ],
    'LaptopGaming' => [
      'model' => LaptopGamingDetail::class,
      'type' => 'LaptopGaming'
    ],
    'GPU' => [
      'model' => GpuDetail::class,
      'type' => 'GPU'
    ],
    'Headset' => [
      'model' => HeadsetDetail::class,
      'type' => 'Headset'
    ],
    'Mouse' => [
      'model' => MouseDetail::class,
      'type' => 'Mouse'
    ],
    'Keyboard' => [
      'model' => KeyboardDetail::class,
      'type' => 'Keyboard'
    ]
    // Thêm các category khác tại đây
  ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'category_id',
        'stock',
        'price',
        'status',
        'image_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'stock' => 'integer',
        'price' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // Add any fields you want to hide from JSON responses
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'stock' => 0,
        'status' => 'hiện',
    ];

    /**
     * Get the category that owns the product.
     */
    // Lấy thông tin category của sản phẩm
    // $product = Product::find(1);
    // $category = $product->category;
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function laptopDetail()
    {
        return $this->hasOne(LaptopDetail::class, 'product_id');
    }

    public function laptopGamingDetail()
    {
        return $this->hasOne(LaptopGamingDetail::class, 'product_id');
    }

    public function screenDetail()
    {
        return $this->hasOne(ScreenDetail::class, 'product_id');
    }

    /**
     * Relationship với GPU Detail
     */
    public function gpuDetail()
    {
        return $this->hasOne(GpuDetail::class, 'product_id');
    }

    /**
     * Relationship với Headset Detail
     */
    public function headsetDetail()
    {
        return $this->hasOne(HeadsetDetail::class, 'product_id');
    }

    /**
     * Relationship với Mouse Detail
     */
    public function mouseDetail()
    {
        return $this->hasOne(MouseDetail::class, 'product_id');
    }

    /**
     * Relationship với Keyboard Detail
     */
    public function keyboardDetail()
    {
        return $this->hasOne(KeyboardDetail::class, 'product_id');
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'hiện');
    }

    /**
     * Scope a query to only include products in stock.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Check if the product is in stock.
     *
     * @return bool
     */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Check if the product is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === 'hiện';
    }

    /**
     * Format price with currency (optional)
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price) . ' VND';
    }

    // Thêm các methods hỗ trợ trong Product model
    public function getAttributeLabels()
    {
        $categoryMapping = [
            'Laptop' => LaptopDetail::getFilterAttributes(),
            'Screen' => ScreenDetail::getFilterAttributes(),
            'GPU' => GpuDetail::getFilterAttributes(),
            'Headset' => HeadsetDetail::getFilterAttributes(),
            'Mouse' => MouseDetail::getFilterAttributes(),
            'Keyboard' => KeyboardDetail::getFilterAttributes(),
        ];

        return $categoryMapping[$this->category_id] ?? [];
    }

    public function getDetail()
    {
        $mapping = [
            'Laptop' => 'laptopDetail',
            'Screen' => 'screenDetail',
            'GPU' => 'gpuDetail',
            'Headset' => 'headsetDetail',
            'Mouse' => 'mouseDetail',
            'Keyboard' => 'keyboardDetail',
        ];

        $relation = $mapping[$this->category_id] ?? null;
        return $relation ? $this->$relation : null;
    }

    public static function getRelationName($categoryId)
    {
        $relations = [
            'Laptop' => 'laptopDetail',
            'Screen' => 'screenDetail',
            'LaptopGaming' => 'laptopGamingDetail',
            'GPU' => 'gpuDetail',
            'Headset' => 'headsetDetail',
            'Mouse' => 'mouseDetail',
            'Keyboard' => 'keyboardDetail'
        ];

        return $relations[$categoryId] ?? null;
    }
}
