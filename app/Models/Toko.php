<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Toko extends Model
{
    use HasFactory;
    protected $table = 'Toko';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_toko','alamat'];

    public function sepedalistrik(): HasMany
    {
        return $this->hasMany(SepedaListrik::class);
    }
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
