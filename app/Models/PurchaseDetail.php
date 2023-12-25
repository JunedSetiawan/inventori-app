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

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function inventori()
    {
        return $this->belongsTo(Inventori::class);
    }
}
