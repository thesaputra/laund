<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
  protected $table = 'incomes';
  protected $primarykey = 'id';
  protected $fillable = array('trans_date','description','price_income','deleted');
  protected $hidden = ['id', 'created_at', 'updated_at'];
}
