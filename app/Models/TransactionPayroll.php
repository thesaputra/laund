<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionPayroll extends Model
{
  protected $table = 'transaction_payrolls';
  protected $primarykey = 'id';
  protected $fillable = array('user_id','payroll_date','gpk_tag','gpk_cuci','gpk_setrika','gpk_packing','gpk_qc','bonus','description','deleted');
  protected $hidden = ['id', 'created_at', 'updated_at'];

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
