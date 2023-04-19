<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::controller(AuthController::class)->group(function () {
    Route::match(['GET', 'POST'], '/login', [AuthController::class, 'login'])->name('login');
    Route::match(['GET', 'POST'], 'register', [AuthController::class, 'register'])->name('register');
    Route::match(['GET', 'POST'], 'logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::match(['GET', 'POST'], 'corpses', [AdminController::class, 'corpses'])->name('corpses');
    Route::match(['GET', 'POST'], 'admit', [AdminController::class, 'admit'])->name('admit');
    Route::match(['GET', 'POST'], 'release', [AdminController::class, 'release'])->name('release');
    
    Route::post('/billing_import', [BillingImportController::class, 'import'])->name('billing_import');
    Route::post('/payment_import', [PaymentImportController::class, 'import'])->name('payment_import');
    Route::match(['GET', 'POST'], 'payments', [AdminController::class, 'payments'])->name('payments');
    Route::get('get_billings', [AdminController::class, 'get_billings'])->name('get_billings');
    Route::get('get_payments', [AdminController::class, 'get_payments'])->name('get_payments');
    Route::delete('delete_billing', [AdminController::class, 'delete_billing'])->name('delete_billing');
    Route::delete('delete_payment', [AdminController::class, 'delete_payment'])->name('delete_payment');
    Route::match(['GET', "POST"], 'generate_report', [AdminController::class, 'generate_report'])->name('generate_report');
    Route::match(['GET', "POST"], 'generate_report_usd', [AdminController::class, 'generate_report_usd'])->name('generate_report_usd');
    Route::match(['GET', "POST"], 'get_summary', [AdminController::class, 'get_summary'])->name('get_summary');
    Route::match(['GET', "POST"], 'get_summary_usd', [AdminController::class, 'get_summary_usd'])->name('get_summary_usd');
    Route::match(['GET', "POST"], 'create_session', [AuditPeriodController::class, 'create_session'])->name('create_session');
    Route::get('/change_session', [AuditPeriodController::class, 'change_session'])->name('change_session');
    Route::get('/periods', [AuditPeriodController::class, 'periods'])->name('periods');
    Route::delete('/delete_session', [AuditPeriodController::class, 'delete_session'])->name('delete_session');
    Route::get('/view_period', [AuditPeriodController::class, 'view_period'])->name('view_period');
    Route::match(['GET', 'POST'], '/airlines', [AirlineController::class, 'airlines'])->name('airlines');
    Route::post('/airline_import', [AirlineController::class, 'airline_import'])->name('airline_import');
    Route::get('/get_airlines', [AirlineController::class, 'get_airlines'])->name('get_airlines');
    Route::delete('/delete_airline', [AirlineController::class, 'delete_airline'])->name('delete_airline');
    Route::get('/get_airline', [AirlineController::class, 'get_airline'])->name('get_airline');
    Route::put('/airline_edit', [AirlineController::class, 'airline_edit'])->name('airline_edit');

    
    Route::match(['GET', 'POST'], 'users', [AuthController::class, 'users'])->name('users');
    Route::delete('delete_user', [AuthController::class, 'delete_user'])->name('delete_user');
    Route::get('get_user', [AuthController::class, 'get_user'])->name('get_user');
    Route::put('update_user', [AuthController::class, 'update_user'])->name('update_user');
    Route::put('update_password', [AuthController::class, 'update_password'])->name('update_password');
});
