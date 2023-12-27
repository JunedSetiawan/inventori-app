<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'inventori_id',
        'qty',
        'price',
    ];

    /**
     * Get the sales that owns the sales detail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    /**
     * Get the inventori that owns the sales detail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventori()
    {
        return $this->belongsTo(Inventori::class);
    }

    /**
     * Get the subtotal attribute.
     *
     * @return float
     */
    public function getSubTotalAttribute()
    {
        return $this->qty * $this->price;
    }
}
