<?php

namespace App\Models;

use App\Traits\CustomId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, CustomId, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'amount',
    ];

    protected static function booted()
    {
        static::creating(function (self $model) {
            $model->id = self::setCustomIdStatic($model);
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'sale_products', 'sale_id', 'product_id');
    }
}
