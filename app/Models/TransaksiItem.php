<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'produks_id',
        'transaksis_id',
    ];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id', 'produks_id');
    }
}
