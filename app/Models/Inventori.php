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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($inventori) {
            $inventori->code = (string) Str::uuid();
        });
    }
}
