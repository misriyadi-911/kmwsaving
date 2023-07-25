<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'employe_id';
    protected $fillable = ['user_account_id', 'role_id', 'address', 'phone', 'gender', 'createdAt', 'updatedAt'];

    public function user () : HasOne {
        return $this->hasOne(UserAccount::class, 'user_account_id', 'user_account_id');
    }
}
