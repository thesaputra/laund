<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
  protected $table = 'packages';
  protected $primarykey = 'id';
  protected $fillable = array('name','price_regular','price_express','price_opr','unit','description');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function transaction_details()
	{
		return $this->hasMany('App\Models\TransactionDetail');
	}

  public function transaction_users()
  {
    return $this->hasMany('App\Models\TransactionUser');
  }
}
