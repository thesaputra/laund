<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
  protected $table = 'transaction_items';
  protected $primarykey = 'id';
  protected $fillable = array('transaction_id','item_id','qty','description');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function item()
  {
    return $this->belongsTo('App\Models\Item');
  }

  public function transaction()
  {
    return $this->belongsTo('App\Models\Transaction');
  }
}
