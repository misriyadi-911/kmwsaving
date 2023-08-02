<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilgrims extends Model
{
    protected $table = 'pilgrims';
    protected $primaryKey = 'pilgrims_id';
    protected $fillable = ['user_account_id', 'bank_account_name', 'kode', 'birth_day','saving_category_id', 'bank_name', 'no_rekening', 'nik', 'no_kk', 'gender', 'phone', 'address'];
    
    public function user () {
        return $this->belongsTo(UserAccount::class, 'user_account_id', 'user_account_id');
    }

    public function saving_category () {
        return $this->belongsTo(SavingCatrgories::class, 'saving_category_id', 'saving_category_id');
    }
}
