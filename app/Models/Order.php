<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'total_amount',
        'tax_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'product_id',
        'tax_id',
    ];

    protected $with = [
        'product',
        'tax',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function scopeOrderDateRange(Builder $query, string $from, string $to): ?Builder
    {
        return $query->whereDate('updated_at', '>=', Carbon::parse($from)->toDateString())->whereDate('updated_at', '<=', Carbon::parse($to)->toDateString());
    }
}
