<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionUser extends Model
{
  protected $table = 'transaction_users';
  protected $primarykey = 'id';
  protected $fillable = array('transaction_id','user_id','qty','unit','package_id','start_date','end_date','status');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function package()
  {
    return $this->belongsTo('App\Models\Package');
  }

  public function transaction()
  {
    return $this->belongsTo('App\Models\Transaction');
  }
}
