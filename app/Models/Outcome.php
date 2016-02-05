<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
  protected $table = 'outcomes';
  protected $primarykey = 'id';
  protected $fillable = array('trans_date','store_name','type_trans','store_tlp','qty','description','price_income','deleted');
  protected $hidden = ['id', 'created_at', 'updated_at'];
}
