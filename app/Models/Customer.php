<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $table = 'customers';
  protected $primarykey = 'id';
  protected $fillable = array('name','code','address','phone','membership');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function transactions()
	{
		return $this->hasMany('App\Models\Transaction');
	}

}
