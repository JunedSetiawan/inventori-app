<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Inventori extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'code',
        'name',
        'price',
        'stock',
    ];

    /**
     * The boot method is called when the model is being booted.
     * It registers an event listener for the 'creating' event,
     * which generates a unique code for the inventori before it is created.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($inventori) {
            $inventori->code = (string) Str::uuid();
        });
    }
}
