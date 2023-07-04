<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CadaverController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryHistoyController;
use App\Http\Controllers\PaymentHistoryController;
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
Route::get('/chart-data', [AdminController::class, 'getChartData']);

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
    Route::match(['GET', 'POST'], '/edit_corpse', [CadaverController::class, 'edit_corpse'])->name('edit_corpse');
    Route::get('/get_num_of_days', [CadaverController::class, 'get_num_of_days'])->name('get_num_of_days');
    Route::get('/add_days', [CadaverController::class, 'add_days'])->name('add_days');
    Route::post('/update_admission', [CadaverController::class, 'update_admission'])->name('update_admission');
    Route::match(['GET', 'POST'], '/corpses/admit', [CadaverController::class, 'admit'])->name('admit');
    Route::match(['GET', 'POST'], '/corpse/release', [CadaverController::class, 'release'])->name('release');
    Route::match(['GET', 'POST'], '/corpse/update_before_release', [CadaverController::class, 'update_before_release'])->name('update_before_release');
    Route::get('/release_list', [CadaverController::class, 'release_list'])->name('release_list');
    Route::get('/reports', [CadaverController::class, 'reports'])->name('reports');
    Route::get('/get_reports', [CadaverController::class, 'get_reports'])->name('get_reports');
    Route::get('/get_release_list', [CadaverController::class, 'get_release_list'])->name('get_release_list');
    Route::get('/view_by_due_and_to_be_collected_this_month', [CadaverController::class, 'view_by_due_and_to_be_collected_this_month'])->name('view_by_due_and_to_be_collected_this_month');
    Route::get('/get_view_by_due_and_to_be_collected_this_month', [CadaverController::class, 'get_view_by_due_and_to_be_collected_this_month'])->name('get_view_by_due_and_to_be_collected_this_month');

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
    Route::match(['GET', 'POST'],'/update_payment', [CadaverController::class, 'update_payment'])->name('update_payment');

    // payment_history
    Route::get('payment_history', [PaymentHistoryController::class, 'index'])->name('payment_history');
    Route::get('get_payment_history', [PaymentHistoryController::class, 'get_payment_history'])->name('get_payment_history');
    
    // Inventory
    Route::match(['GET', 'POST'], '/inventory', [InventoryController::class,'index'])->name('inventory');
    Route::get('/get_inventory', [InventoryController::class, 'get_inventory'])->name('get_inventory');
    Route::get('/get_item', [InventoryController::class, 'get_item'])->name('get_item');
    Route::put('/edit_item', [InventoryController::class, 'edit_item'])->name('edit_item');
    Route::put('/restock_item', [InventoryController::class, 'restock_item'])->name('restock_item');
    Route::delete('/delete_item', [InventoryController::class, 'delete_item'])->name('delete_item');
    Route::match(['GET', 'POST'],'/item_request', [InventoryController::class, 'item_request'])->name('item_request');
    Route::get('/item_list', [InventoryController::class, 'item_list'])->name('item_list');
    Route::post('/make_request', [InventoryController::class, 'make_request'])->name('make_request');
    Route::get('/request_list', [InventoryController::class, 'request_list'])->name('request_list');
    Route::get('/get_request_list', [InventoryController::class, 'get_request_list'])->name('get_request_list');
    Route::get('/get_requested_item', [InventoryController::class, 'get_requested_item'])->name('get_requested_item');
    Route::post('/approve_request', [InventoryController::class, 'approve_request'])->name('approve_request');
    Route::post('/reject_request', [InventoryController::class, 'reject_request'])->name('reject_request');

    // Inventory Hostory
    Route::get('/inventory/history', [InventoryHistoyController::class, 'history'])->name('history');
    Route::get('/inventory/get_inventory_history', [InventoryHistoyController::class, 'get_inventory_history'])->name('get_inventory_history');
    Route::get('/inventory/get_expenses', [InventoryHistoyController::class, 'get_expenses'])->name('get_expenses');
    Route::match(['GET', 'POST'],'/inventory/expenses', [InventoryHistoyController::class, 'expenses'])->name('expenses');
    Route::match(['GET', 'POST'],'/inventory/expense_category', [ExpenseCategoryController::class, 'expense_category'])->name('expense_category');
    Route::get('/inventory/get_expense_category', [ExpenseCategoryController::class, 'get_expense_category'])->name('get_expense_category');

    // users
    Route::match(['GET', 'POST'], 'users', [AuthController::class, 'users'])->name('users');
    Route::delete('delete_user', [AuthController::class, 'delete_user'])->name('delete_user');
    Route::get('get_user', [AuthController::class, 'get_user'])->name('get_user');
    Route::put('update_user', [AuthController::class, 'update_user'])->name('update_user');
    Route::post('switch_user', [AuthController::class, 'switch_user'])->name('switch_user');
    Route::put('update_password', [AuthController::class, 'update_password'])->name('update_password');
});
