<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  protected $table = 'transactions';
  protected $primarykey = 'id';
  protected $fillable = array('deleted', 'date_order','date_deliver','customer_id','user_id','status_id','time_deliver','amount_dp','amount_left','discount','description','invoice_number','rack_info','date_checkout');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function customer()
	{
		return $this->belongsTo('App\Models\Customer');
	}

  public function user()
	{
		return $this->belongsTo('App\User');
	}

  public function status()
	{
		return $this->belongsTo('App\Models\Status');
	}

  public function transaction_details()
	{
		return $this->hasMany('App\Models\TransactionDetail');
	}

  public function transaction_items()
	{
		return $this->hasMany('App\Models\TransactionItem');
	}

  public function transaction_users()
  {
    return $this->hasMany('App\Models\TransactionUser');
  }

  public function payment_histories()
  {
    return $this->hasMany('App\Models\PaymentHistory');
  }
}
