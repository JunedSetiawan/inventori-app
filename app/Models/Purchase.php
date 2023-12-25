<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sales) {
            $sales->generateNumber();
        });
    }

    public function generateNumber(): void
    {
        $this->attributes['number'] = 'INV' . date('Ymd') . '-' . sprintf('%04d', static::max('id') + 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseDetail()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
