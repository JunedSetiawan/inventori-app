<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'user_id',
    ];

    /**
     * Purchase Model
     *
     * This model represents a purchase in the application.
     * It contains methods for generating a purchase number,
     * as well as defining relationships with other models.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($sales) {
            $sales->generateNumber();
        });
    }

    /**
     * Generate a purchase number.
     *
     * This method generates a unique purchase number based on the current date and the maximum ID in the table.
     * The generated number is stored in the 'number' attribute of the Purchase model.
     *
     * @return void
     */
    public function generateNumber(): void
    {
        $this->attributes['number'] = 'INV' . date('Ymd') . '-' . sprintf('%04d', static::max('id') + 1);
    }

    /**
     * Get the user associated with the purchase.
     *
     * This method defines a belongsTo relationship with the User model,
     * indicating that a purchase belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the purchase details associated with the purchase.
     *
     * This method defines a hasMany relationship with the PurchaseDetail model,
     * indicating that a purchase can have multiple purchase details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseDetail(): HasMany
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
