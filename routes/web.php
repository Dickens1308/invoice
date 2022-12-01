<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/mailable', function () {
//    $invoice = Invoice::find(1)->with('order')->first();
//    $customer = Customer::findorFail(1);
//    return new App\Mail\InvoiceMail($invoice, $customer);
//});
//

Route::get('/{path?}', function () {
    return View::make('app');
})->where('path', '.*');
