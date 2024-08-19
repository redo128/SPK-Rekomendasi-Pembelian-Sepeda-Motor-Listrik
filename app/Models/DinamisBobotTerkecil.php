<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DinamisBobotTerkecil extends Model
{
    use HasFactory;
    protected $table = 'dinamis_bobot_terkecil';
    protected $primaryKey = 'id';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
