<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SepedaListrik extends Model
{
    use HasFactory;
    protected $table ="sepeda_listrik";
    protected $primaryKey = 'id';
    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
