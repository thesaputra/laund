<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $table = 'items';
  protected $primarykey = 'id';
  protected $fillable = array('name');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function transaction_items()
	{
		return $this->hasMany('App\Models\TransactionItem');
	}
}
