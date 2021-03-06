<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
  protected $table = 'status';
  protected $primarykey = 'id';
  protected $fillable = array('name');
  protected $hidden = ['id', 'created_at', 'updated_at'];


  public function transactions()
	{
		return $this->hasMany('App\Models\Transaction');
	}
}
