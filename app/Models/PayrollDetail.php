<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
  protected $table = 'payroll_details';
  protected $primarykey = 'id';
  protected $fillable = array('transaction_payroll_id','desc_payroll','satuan','jenis_satuan','qty','amount');
  protected $hidden = ['id', 'created_at', 'updated_at'];

 
  public function transaction_payroll()
	{
		return $this->belongsTo('App\Models\TransactionPayroll');
	}
}
