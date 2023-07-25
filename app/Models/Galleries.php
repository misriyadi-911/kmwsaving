<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{
    protected $table = 'galleries';
    protected $primaryKey = 'gallery_id';
    protected $fillable = ['information_id', 'picture'];

    public function information () {
        return $this->belongsTo(Informations::class, 'information_id', 'information_id');
    }
}
