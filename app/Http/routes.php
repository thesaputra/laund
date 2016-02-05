<?php

use App\User;
use Illuminate\Support\Facades\Auth;

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('/',[
  'middleware' => ['auth', 'roles'],
  'as' => 'admin.customer',
  'uses' => 'CustomerController@index',
  'roles' => ['Admin', 'Owner']
]);


Route::group(array('prefix' => 'admin'),function() {

  Route::get('users', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.user',
      'uses' => 'UserController@index',
      'roles' => ['Admin','Owner']
  ]);

  Route::get('user_data', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.get_user',
      'uses' => 'UserController@user_data',
      'roles' => ['Admin','Owner']
  ]);

  Route::get('user/create', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.user.create',
      'uses' => 'UserController@create',
      'roles' => ['Admin','Owner']
  ]);

  Route::post('user/store', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.user.store',
      'uses' => 'UserController@store',
      'roles' => ['Admin','Owner']
  ]);

  Route::get('user/edit/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.user.edit',
      'uses' => 'UserController@edit',
      'roles' => ['Admin','Owner']
  ]);

  Route::patch('user/update/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.user.update',
      'uses' => 'UserController@update',
      'roles' => ['Admin','Owner']
  ]);

  Route::delete('user/destroy/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.user.destroy',
      'uses' => 'UserController@destroy',
      'roles' => ['Admin','Owner']
  ]);

  Route::get('report/index', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.report.index',
      'uses' => 'ReportController@index',
      'roles' => ['Admin', 'Owner']
  ]);
  Route::post('report/process', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.report.process',
      'uses' => 'ReportController@process',
      'roles' => ['Admin', 'Owner']
  ]);
  Route::get('report/status', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.report.status',
      'uses' => 'ReportController@status',
      'roles' => ['Admin', 'Owner']
  ]);
  Route::get('report/daily', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.report.daily',
      'uses' => 'ReportController@daily',
      'roles' => ['Admin', 'Owner']
  ]);
  Route::post('report/process_daily', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.report.process_daily',
      'uses' => 'ReportController@process_daily',
      'roles' => ['Admin', 'Owner']
  ]);
  Route::post('report/process_status', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.report.process_status',
      'uses' => 'ReportController@process_status',
      'roles' => ['Admin', 'Owner']
  ]);
});

Route::group(array('prefix' => 'admin'),function() {
  Route::get('customer', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.customer',
      'uses' => 'CustomerController@index',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('customers', [
      'middleware' => ['auth', 'roles'],
      'as' => 'data.customer',
      'uses' => 'CustomerController@customer_data',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('customer/create', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.customer.create',
      'uses' => 'CustomerController@create',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::post('customer/store', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.customer.store',
      'uses' => 'CustomerController@store',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('customer/edit/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.customer.edit',
      'uses' => 'CustomerController@edit',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::patch('customer/update/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.customer.update',
      'uses' => 'CustomerController@update',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::patch('customer/delete_customer/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.customer.delete',
      'uses' => 'CustomerController@delete_customer',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('package', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.package',
      'uses' => 'PackageController@index',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('package/package_data', [
      'middleware' => ['auth', 'roles'],
      'as' => 'data.package',
      'uses' => 'PackageController@package_data',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('package/create', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.package.create',
      'uses' => 'PackageController@create',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::post('package/store', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.package.store',
      'uses' => 'PackageController@store',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('package/edit/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.package.edit',
      'uses' => 'PackageController@edit',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::patch('package/update/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.package.update',
      'uses' => 'PackageController@update',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('status', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.status',
      'uses' => 'StatusController@index',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('status/status_data', [
      'middleware' => ['auth', 'roles'],
      'as' => 'data.status',
      'uses' => 'StatusController@status_data',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('status/create', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.status.create',
      'uses' => 'StatusController@create',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::post('status/store', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.status.store',
      'uses' => 'StatusController@store',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('status/edit/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.status.edit',
      'uses' => 'StatusController@edit',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::patch('status/update/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.status.update',
      'uses' => 'StatusController@update',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('item', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.item',
      'uses' => 'ItemController@index',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('items', [
      'middleware' => ['auth', 'roles'],
      'as' => 'data.item',
      'uses' => 'ItemController@item_data',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('item/create', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.item.create',
      'uses' => 'ItemController@create',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::post('item/store', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.item.store',
      'uses' => 'ItemController@store',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('item/edit/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.item.edit',
      'uses' => 'ItemController@edit',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::patch('item/update/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'admin.item.update',
      'uses' => 'ItemController@update',
      'roles' => ['Admin', 'Owner']
  ]);

});


Route::group(array('prefix' => 'payroll'),function() {

  Route::get('report', [
      'middleware' => ['auth', 'roles'],
      'as' => 'payroll.report',
      'uses' => 'TransactionPayrollController@report',
      'roles' => ['Admin', 'Owner']
  ]);

    Route::post('report/process', [
      'middleware' => ['auth', 'roles'],
      'as' => 'payroll.report.process',
      'uses' => 'TransactionPayrollController@process_report',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('payroll', [
      'middleware' => ['auth', 'roles'],
      'as' => 'payroll.payroll',
      'uses' => 'TransactionPayrollController@index',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('payroll/payroll_data', [
      'middleware' => ['auth', 'roles'],
      'as' => 'data.payroll',
      'uses' => 'TransactionPayrollController@payroll_data',
      'roles' => ['Admin', 'Owner']
  ]);
  Route::get('payroll/create', [
       'middleware' => ['auth', 'roles'],
       'as' => 'payroll.payroll.create',
       'uses' => 'TransactionPayrollController@create',
       'roles' => ['Admin', 'Owner']
   ]);
  Route::post('payroll/store', [
       'middleware' => ['auth', 'roles'],
       'as' => 'payroll.payroll.store',
       'uses' => 'TransactionPayrollController@store',
       'roles' => ['Admin', 'Owner']
   ]);
  Route::get('payroll/edit/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'payroll.payroll.edit',
      'uses' => 'TransactionPayrollController@edit',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::patch('payroll/update/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'payroll.payroll.update',
      'uses' => 'TransactionPayrollController@update',
      'roles' => ['Admin', 'Owner']
  ]);

   Route::patch('payroll/destroy/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'payroll.payroll.destroy',
       'uses' => 'TransactionPayrollController@destroy',
       'roles' => ['Admin', 'Owner']
   ]);

});  

 Route::group(array('prefix' => 'kasir'),function() {
   Route::get('transaction', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction',
       'uses' => 'TransactionController@index',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::patch('transaction/delete_transaction/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.delete_transaction',
       'uses' => 'TransactionController@delete_transaction',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transactions', [
       'middleware' => ['auth', 'roles'],
       'as' => 'data.transaction',
       'uses' => 'TransactionController@transaction_data',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transaction/create', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.create',
       'uses' => 'TransactionController@create',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transaction/print_invoice/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.print_invoice',
       'uses' => 'TransactionController@print_invoice',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transaction/print_item/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.print_item',
       'uses' => 'TransactionController@print_item',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transaction/edit/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.edit',
       'uses' => 'TransactionController@edit',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::post('transaction/store', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.store',
       'uses' => 'TransactionController@store',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::post('transaction/store_detail', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.store_detail',
       'uses' => 'TransactionController@store_detail',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::post('transaction/store_item', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.store_item',
       'uses' => 'TransactionController@store_item',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::post('transaction/store_user', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.store_user',
       'uses' => 'TransactionController@store_user',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::post('transaction/store_pcs', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.store_pcs',
       'uses' => 'TransactionController@store_pcs',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::post('transaction/store_payment', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.store_payment',
       'uses' => 'TransactionController@store_payment',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::get('transaction/detail/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.detail',
       'uses' => 'TransactionController@detail',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::delete('transaction/destroy_detail/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.destroy_detail',
       'uses' => 'TransactionController@destroy_detail',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::delete('transaction/destroy_detail_user/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.destroy_detail_user',
       'uses' => 'TransactionController@destroy_detail_user',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::delete('transaction/destroy_detail_user_pcs/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.destroy_detail_user_pcs',
       'uses' => 'TransactionController@destroy_detail_user_pcs',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::delete('transaction/destroy_detail_item/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.destroy_detail_item',
       'uses' => 'TransactionController@destroy_detail_item',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::delete('transaction/destroy_history_payment/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.destroy_history_payment',
       'uses' => 'TransactionController@destroy_history_payment',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transaction/detail_item/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.detail_item',
       'uses' => 'TransactionController@detail_item',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transaction/detail_user/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.detail_user',
       'uses' => 'TransactionController@detail_user',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::patch('transaction/update_status/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.update_status',
       'uses' => 'TransactionController@update_status',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::patch('transaction/update_status_pcs/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.update_status_pcs',
       'uses' => 'TransactionController@update_status_pcs',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('package/edit/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'admin.transaction.edit',
       'uses' => 'TransactionController@edit',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::patch('transaction/update/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.update',
       'uses' => 'TransactionController@update',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::get('transaction/autocomplete', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.autocomplete',
       'uses' => 'TransactionController@customer_autocomplete',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::get('transaction/package_autocomplete', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.package_autocomplete',
       'uses' => 'TransactionController@package_autocomplete',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transaction/package_autocomplete_trans', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.package_autocomplete_trans',
       'uses' => 'TransactionController@package_autocomplete_trans',
       'roles' => ['Admin', 'Owner']
   ]);

   Route::get('transaction/package_autocomplete_pcs', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.package_autocomplete_pcs',
       'uses' => 'TransactionController@package_autocomplete_pcs',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::get('transaction/item_autocomplete', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.item_autocomplete',
       'uses' => 'TransactionController@item_autocomplete',
       'roles' => ['Admin', 'Owner']
   ]);
   Route::get('transaction/user_autocomplete', [
       'middleware' => ['auth', 'roles'],
       'as' => 'kasir.transaction.user_autocomplete',
       'uses' => 'TransactionController@user_autocomplete',
       'roles' => ['Admin', 'Owner']
   ]);

 });


Route::group(array('prefix' => 'income'),function() {
  Route::get('income', [
      'middleware' => ['auth', 'roles'],
      'as' => 'income.income',
      'uses' => 'IncomeController@index',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('income/income_data', [
      'middleware' => ['auth', 'roles'],
      'as' => 'data.income',
      'uses' => 'IncomeController@income_data',
      'roles' => ['Admin', 'Owner']
  ]);
  Route::get('income/create', [
       'middleware' => ['auth', 'roles'],
       'as' => 'income.income.create',
       'uses' => 'IncomeController@create',
       'roles' => ['Admin', 'Owner']
   ]);
  Route::post('income/store', [
       'middleware' => ['auth', 'roles'],
       'as' => 'income.income.store',
       'uses' => 'IncomeController@store',
       'roles' => ['Admin', 'Owner']
   ]);
  Route::get('income/edit/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'income.income.edit',
      'uses' => 'IncomeController@edit',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::patch('income/update/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'income.income.update',
      'uses' => 'IncomeController@update',
      'roles' => ['Admin', 'Owner']
  ]);

   Route::patch('income/destroy/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'income.income.destroy',
       'uses' => 'IncomeController@destroy',
       'roles' => ['Admin', 'Owner']
   ]);

});  


Route::group(array('prefix' => 'outcome'),function() {
  Route::get('outcome', [
      'middleware' => ['auth', 'roles'],
      'as' => 'outcome.outcome',
      'uses' => 'OutcomeController@index',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::get('outcome/outcome_data', [
      'middleware' => ['auth', 'roles'],
      'as' => 'data.outcome',
      'uses' => 'OutcomeController@outcome_data',
      'roles' => ['Admin', 'Owner']
  ]);
  Route::get('outcome/create', [
       'middleware' => ['auth', 'roles'],
       'as' => 'outcome.outcome.create',
       'uses' => 'OutcomeController@create',
       'roles' => ['Admin', 'Owner']
   ]);
  Route::post('outcome/store', [
       'middleware' => ['auth', 'roles'],
       'as' => 'outcome.outcome.store',
       'uses' => 'OutcomeController@store',
       'roles' => ['Admin', 'Owner']
   ]);
  Route::get('outcome/edit/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'outcome.outcome.edit',
      'uses' => 'OutcomeController@edit',
      'roles' => ['Admin', 'Owner']
  ]);

  Route::patch('outcome/update/{id}', [
      'middleware' => ['auth', 'roles'],
      'as' => 'outcome.outcome.update',
      'uses' => 'OutcomeController@update',
      'roles' => ['Admin', 'Owner']
  ]);

   Route::patch('outcome/destroy/{id}', [
       'middleware' => ['auth', 'roles'],
       'as' => 'outcome.outcome.destroy',
       'uses' => 'OutcomeController@destroy',
       'roles' => ['Admin', 'Owner']
   ]);

});  
