<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
  protected $table = 'payment_histories';
  protected $primarykey = 'id';
  protected $fillable = array('transaction_id','amount','description');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function transaction()
  {
    return $this->belongsTo('App\Models\Transaction');
  }
}
