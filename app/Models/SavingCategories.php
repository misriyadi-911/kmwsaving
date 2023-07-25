<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingCategories extends Model
{
    protected $table = 'saving_categories';
    protected $primaryKey = 'saving_category_id';
    protected $fillable = ['name', 'limit'];
}
