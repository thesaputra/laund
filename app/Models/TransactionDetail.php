<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
  protected $table = 'transaction_details';
  protected $primarykey = 'id';
  protected $fillable = array('transaction_id','package_id','package_type','qty');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function package()
	{
		return $this->belongsTo('App\Models\Package');
	}

  public function transaction()
	{
		return $this->belongsTo('App\Models\Transaction');
	}
}
