<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionalSavings extends Model
{
    protected $table = 'transactional_savings';
    protected $primaryKey = 'transactional_savings_id';
    protected $fillable = ['pilgrims_id', 'nominal', 'type'];

    public function pilgrim () {
        return $this->belongsTo(Pilgrims::class, 'pilgrims_id', 'pilgrims_id');
    }
}
