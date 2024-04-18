<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlternatifSelectPembeli extends Model
{
    use HasFactory;
    protected $table = 'alternatif_select_user';
    protected $primaryKey = 'id';
    public function sepedalistrik(): BelongsTo
    {
        return $this->BelongsTo(SepedaListrik::class);
    }
    
}
