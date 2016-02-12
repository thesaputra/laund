<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutcomeDetail extends Model
{
  protected $table = 'outcome_details';
  protected $primarykey = 'id';
  protected $fillable = array('outcome_id','desc_outcome','qty','price');
  protected $hidden = ['id', 'created_at', 'updated_at'];

 
  public function outcome()
	{
		return $this->belongsTo('App\Models\Outcome');
	}
}
