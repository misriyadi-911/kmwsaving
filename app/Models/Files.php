<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'file_id';
    protected $fillable = ['user_id', 'file', 'name'];

    public function pilgrim () {
        return $this->belongsTo(Pilgrims::class, 'user_id', 'pilgrims_id');
    }
}
