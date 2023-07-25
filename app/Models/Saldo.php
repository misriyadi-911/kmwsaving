<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $table = 'saldo';
    protected $primaryKey = 'saldo_id';
    protected $fillable = ['pilgrims_id', 'nominal'];
    
    public function pilgrim () {
        return $this->belongsTo(Pilgrims::class, 'pilgrims_id', 'pilgrims_id');
    }
}
