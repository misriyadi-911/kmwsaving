<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartureInformation extends Model
{
    protected $table = 'departure_informations';
    protected $primaryKey = 'departure_information_id';
    protected $fillable = ['pligrims_id', 'time'];

    public function pilgrim () {
        return $this->belongsTo(Pilgrims::class, 'pilgrims_id', 'pilgrims_id');
    }
}
