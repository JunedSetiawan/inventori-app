<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'user_id',
    ];


    /**
     * Sales Model
     *
     * This model represents a sales transaction in the application.
     * It includes methods for generating a unique sales number and defining relationships with other models.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($sales) {
            $sales->generateNumber();
        });
    }

    /**
     * Generate a unique sales number.
     *
     * This method generates a unique sales number for the current sales instance.
     * The sales number is formatted as 'INV' followed by the current date (Ymd) and a sequential number.
     */
    public function generateNumber(): void
    {
        $this->attributes['number'] = 'INV' . date('Ymd') . '-' . sprintf('%04d', static::max('id') + 1);
    }

    /**
     * Get the user associated with the sales transaction.
     *
     * This method defines a belongsTo relationship with the User model.
     * It returns the user associated with the sales transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sales details associated with the sales transaction.
     *
     * This method defines a hasMany relationship with the SalesDetail model.
     * It returns the sales details associated with the sales transaction.
     */
    public function salesDetail(): HasMany
    {
        return $this->hasMany(SalesDetail::class);
    }
}
