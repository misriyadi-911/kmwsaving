<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    protected $primaryKey = 'notification_id';
    protected $fillable = ['pilgrims_id','transactional_savings_id','message','status',];
}
