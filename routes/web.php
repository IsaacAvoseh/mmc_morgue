<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CadaverController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\ServicesController;
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

    // Cadaver
    Route::match(['GET', 'POST'], '/corpses', [CadaverController::class, 'index'])->name('corpses');
    Route::get('/get_corpses', [CadaverController::class, 'get_corpses'])->name('get_corpses');
    Route::get('/get_corpse', [CadaverController::class, 'get_corpse'])->name('get_corpse');
    Route::get('/get_num_of_days', [CadaverController::class, 'get_num_of_days'])->name('get_num_of_days');
    Route::get('/add_days', [CadaverController::class, 'add_days'])->name('add_days');
    Route::post('/update_admission', [CadaverController::class, 'update_admission'])->name('update_admission');
    Route::match(['GET', 'POST'], '/corpses/admit', [CadaverController::class, 'admit'])->name('admit');
    Route::match(['GET', 'POST'], '/corpse/release', [CadaverController::class, 'release'])->name('release');
    Route::match(['GET', 'POST'], '/corpse/update_before_release', [CadaverController::class, 'update_before_release'])->name('update_before_release');

    // Racks
    Route::match(['GET', 'POST'], '/racks', [RackController::class, 'racks'])->name('racks');
    Route::get('/get_racks', [RackController::class, 'get_racks'])->name('get_racks');
    Route::get('/get_rack', [RackController::class, 'get_rack'])->name('get_rack');
    Route::delete('/delete_rack', [RackController::class, 'delete_rack'])->name('delete_rack');
    Route::put('/rack_edit', [RackController::class, 'rack_edit'])->name('rack_edit');
    
    // Documents
    Route::match(['GET', 'POST'], '/documents', [DocumentController::class, 'documents'])->name('documents');
    Route::get('/get_documents', [DocumentController::class, 'get_documents'])->name('get_documents');
    Route::get('/get_document', [DocumentController::class, 'get_document'])->name('get_document');
    Route::delete('/delete_document', [DocumentController::class, 'delete_document'])->name('delete_document');
    Route::put('/document_edit', [DocumentController::class, 'document_edit'])->name('document_edit');
    
    // Services
    Route::match(['GET', 'POST'], '/services', [ServicesController::class, 'services'])->name('services');
    Route::get('/get_services', [ServicesController::class, 'get_services'])->name('get_services');
    Route::get('/get_service', [ServicesController::class, 'get_service'])->name('get_service');
    Route::delete('/delete_service', [ServicesController::class, 'delete_service'])->name('delete_service');
    Route::put('/service_edit', [ServicesController::class, 'service_edit'])->name('service_edit');
    
    // payment
    Route::post('/with_payment', [CadaverController::class, 'with_payment'])->name('with_payment');
    Route::get('/without_payment', [CadaverController::class, 'without_payment'])->name('without_payment');


    
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
    Route::get('/get_airline', [AirlineController::class, 'get_airline'])->name('get_airline');

    
    Route::match(['GET', 'POST'], 'users', [AuthController::class, 'users'])->name('users');
    Route::delete('delete_user', [AuthController::class, 'delete_user'])->name('delete_user');
    Route::get('get_user', [AuthController::class, 'get_user'])->name('get_user');
    Route::put('update_user', [AuthController::class, 'update_user'])->name('update_user');
    Route::put('update_password', [AuthController::class, 'update_password'])->name('update_password');
});
