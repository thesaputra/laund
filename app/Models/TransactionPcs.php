<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionPcs extends Model
{
  protected $table = 'transaction_pcs';
  protected $primarykey = 'id';
  protected $fillable = array('transaction_id','user_id','qty','unit','package_id','package_type','start_date','end_date','status','price','package_detail','description');
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
