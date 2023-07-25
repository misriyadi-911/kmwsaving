<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informations extends Model
{
    protected $table = 'informations';
    protected $primaryKey = 'information_id';
    protected $fillable = ['tittle', 'description'];
}
