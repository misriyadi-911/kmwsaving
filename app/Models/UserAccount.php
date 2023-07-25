<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = 'user_account';
    protected $primaryKey = 'user_account_id';
    protected $fillable = ['username', 'email', 'password', 'type', 'thumbnail'];
}
