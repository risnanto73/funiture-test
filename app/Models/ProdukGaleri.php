<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukGaleri extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'produks_id',
        'url',
        'is_featured',
    ];
}
