<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'inventori_id',
        'qty',
        'price',
    ];

    /**
     * Get the purchase that owns the purchase detail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the inventori that owns the purchase detail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventori()
    {
        return $this->belongsTo(Inventori::class);
    }

    /**
     * Get the subtotal attribute for the purchase detail.
     *
     * @return float
     */
    public function getSubTotalAttribute()
    {
        return $this->qty * $this->price;
    }
}
