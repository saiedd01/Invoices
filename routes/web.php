<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes(['verfiy' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

/* ***************** Delete file Attachment of Invoices ******************* */
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy']);

/* ****************** Delete Inovices ********************** */
Route::post('delete', [InvoiceController::class, "destroy"]);

/* ***************** Change Status Invoices ******************* */
Route::get('Status_show/{id}', [InvoiceController::class, 'show']);
Route::post('Status_Update/{id}', [InvoiceController::class, 'status_update']);

/* ***************** Edit Invoices ******************* */
Route::get('edit_invoice/{id}', [InvoiceController::class, 'edit']);
Route::post('invoices/update/{id}', [InvoiceController::class, 'update']);

/* ***************** Show Archive_invoices ******************* */
Route::get('Archive_invoices', [InvoicesArchiveController::class, 'index']);

/* ***************** Restore Archive_invoices ******************* */
Route::post('Archive/restore', [InvoicesArchiveController::class, 'update']);

/* ***************** Delete Archive_invoices ******************* */
Route::post('Archive/delete', [InvoicesArchiveController::class, 'destroy']);


/* ***************** Route CRUD of Invoices ******************* */
Route::resource('invoices', InvoiceController::class);

/* ***************** get Product in Invoices page ******************* */
Route::get('section/{id}', [InvoiceController::class, 'getproducts']);

/* ***************** Show Details of Invoices ******************* */
Route::get('InvoicesDetails/{id}', [InvoicesDetailsController::class, 'show']);

/* ***************** Read Specific Notification ******************* */
Route::get('InvoicesDetails/{invoice_id}/{notification_id}', [InvoicesDetailsController::class, 'show'])->name('invoices.details');

/* ***************** View file attachment of Invoices ******************* */
Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'view_file']);

/* ***************** Download file attachment of Invoices ******************* */
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);

/* ***************** Show Invoices Paid ******************* */
Route::get('invoice_Paid', [InvoiceController::class, 'InvoicesPaid']);

/* ***************** Show Invoice_UnPaid ******************* */
Route::get('Invoice_UnPaid', [InvoiceController::class, 'InvoicesUnPaid']);
/* ***************** Show Invoice_Partial ******************* */
Route::get('Invoice_Partial', [InvoiceController::class, 'Invoice_Partial']);

/* ***************** Print Invoice ******************* */
Route::get('print_invoice/{id}', [InvoiceController::class, 'Print_Invoices']);

/* ***************** Excel Invoice ******************* */
Route::get('export_invoice', [InvoiceController::class, 'Excel']);


/* *************** Invoices Reports ****************** */
Route::get("invoices_reports", [InvoicesReportController::class, "index"]);
Route::post("Search_invoices", [InvoicesReportController::class, "search"]);

/* *************** Customer Reports ****************** */
Route::get("customers_reports", [CustomersReportController::class, "index"]);
Route::post("Search_customer", [CustomersReportController::class, "search"]);

/* ***************** get Product in Customer Reports page ******************* */
Route::get('section/{id}', [CustomersReportController::class, 'getproducts']);


/* ********************* Make Read Notifications ******************* */
Route::get("MakeAllRead", [InvoiceController::class, "Make_All_Read"])->name("MakeAllRead");


/* ***************** Add file Attachment ******************* */
Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);

/* ***************** Route CRUD of Sections ******************* */
Route::resource('sections', SectionsController::class);

/* ***************** Route CRUD of Product ******************* */
Route::resource('products', ProductsController::class);

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/{page}', [AdminController::class, 'index']);
