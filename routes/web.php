<?php
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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/clear-cache', [App\Http\Controllers\CacheClearController::class, 'clearCache']);

Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index']);
Route::get('/customer_add', [App\Http\Controllers\CustomerController::class, 'customer_add']);
Route::post('/customer_add_checkemail', [App\Http\Controllers\CustomerController::class, 'customer_checkemail']);
Route::post('/user_add_checkemail', [App\Http\Controllers\userController::class, 'user_checkemail']);



Route::get('/customer_info/{id}', [App\Http\Controllers\CustomerController::class, 'customer_info']);
Route::get('/delete_customer/{id}', [App\Http\Controllers\CustomerController::class, 'delete_customer']);

Route::post('/add_customer', [App\Http\Controllers\CustomerController::class, 'add_customer']);

Route::get('/service', [App\Http\Controllers\ItemController::class, 'index']);
Route::get('/service_master_add', [App\Http\Controllers\ItemController::class,'item_master_add']);
Route::get('/item_master_add', [App\Http\Controllers\ItemController::class,'item_master_add']);

Route::post('/add_item_master', [App\Http\Controllers\ItemController::class,'add_item_master']);
Route::get('/service_master_edit/{id}', [App\Http\Controllers\ItemController::class,'item_master_edit']);
Route::post('/edit_item_master', [App\Http\Controllers\ItemController::class,'edit_item_master']);
Route::get('/item_cancel/{id}', [App\Http\Controllers\ItemController::class,'item_cancel']);

Route::get('/get-subcategories', [App\Http\Controllers\ItemController::class,'service_subcategories']);

// Route::get('/get-subcategories', function (Request $request) {
//
// });



Route::get('/quotation/{id}', [App\Http\Controllers\QuotationController::class, 'index']);
Route::get('/quotation_add', [App\Http\Controllers\QuotationController::class, 'get_customer_item_list']);
Route::post('/add_quotation', [App\Http\Controllers\QuotationController::class, 'add_quotation']);
Route::get('/quotation_edit/{id}', [App\Http\Controllers\QuotationController::class, 'quotation_edit']);
Route::post('/update_quotation', [App\Http\Controllers\QuotationController::class, 'update_quotation']);
Route::get('/invoice/{id}', [App\Http\Controllers\QuotationController::class, 'invoice']);
Route::get('/quotation_delete/{id}', [App\Http\Controllers\QuotationController::class, 'delete_quotation']);
Route::get('/quotation_approve/{id}', [App\Http\Controllers\QuotationController::class, 'quotation_approve']);
Route::get('/quotation_cancel/{id}', [App\Http\Controllers\QuotationController::class, 'quotation_cancel']);

Route::get('/company_module', [App\Http\Controllers\CompanyModuleController::class, 'index']);
Route::post('/update_module', [App\Http\Controllers\CompanyModuleController::class, 'updinvoiceate_module']);

Route::get('/proforma_invoice', [App\Http\Controllers\ProformaInvoiceController::class, 'index'])->name('proforma_invoice.list');

Route::get('/invoice_add', [App\Http\Controllers\ProformaInvoiceController::class, 'add_new']);
Route::post('/save_invoice', [App\Http\Controllers\ProformaInvoiceController::class, 'save_invoice']);



Route::get('/proforma_invoice_payment/{id}', [App\Http\Controllers\ProformaInvoiceController::class, 'proforma_invoice_payment']);
Route::post('/add_proforma_invoice_payment', [App\Http\Controllers\ProformaInvoiceController::class, 'add_proforma_invoice_payment']);

Route::get('/proforma_invoice_generate/{id}', [App\Http\Controllers\ProformaInvoiceController::class, 'proforma_invoice_generate']);


Route::get('/proforma_invoice_approve/{id}', [App\Http\Controllers\ProformaInvoiceController::class, 'proforma_invoice_approve']);
Route::get('/proforma_invoice_cancel/{id}', [App\Http\Controllers\ProformaInvoiceController::class, 'proforma_invoice_cancel']);

Route::get('/invoice_details/{id}', [App\Http\Controllers\ProformaInvoiceController::class, 'invoice_details']);
Route::get('/final_invoice/{id}', [App\Http\Controllers\ProformaInvoiceController::class, 'final_invoice']);

Route::get('/invoice_list/{id}', [App\Http\Controllers\ProformaInvoiceController::class, 'invoice_list']);

Route::get('/company_address_list', [App\Http\Controllers\CompanyModuleController::class, 'address_list']);
Route::get('/update_address_status/{id}', [App\Http\Controllers\CompanyModuleController::class, 'update_address_status']);
Route::get('/company_address_add', [App\Http\Controllers\CompanyModuleController::class, 'company_address_add']);
Route::post('/add_company_address', [App\Http\Controllers\CompanyModuleController::class, 'add_company_address']);

Route::get('/client_list', [App\Http\Controllers\ClientController::class, 'index']);
Route::get('/client_add', [App\Http\Controllers\ClientController::class,'client_add']);
Route::post('/add_client', [App\Http\Controllers\ClientController::class,'add_client']);

Route::get('/lead_list', [App\Http\Controllers\LeadController::class, 'index']);
Route::get('/lead_add', [App\Http\Controllers\LeadController::class, 'lead_add']);
Route::post('/add_lead', [App\Http\Controllers\LeadController::class, 'add_leads']);
Route::get('/lead_edit/{id}', [App\Http\Controllers\LeadController::class, 'lead_edit']);
Route::post('/update_lead', [App\Http\Controllers\LeadController::class, 'update_lead']);
Route::get('/lead_delete/{id}', [App\Http\Controllers\LeadController::class, 'lead_delete']);
Route::get('/lead_approve/{id}', [App\Http\Controllers\LeadController::class, 'lead_approve']);
Route::get('/lead_cancel/{id}', [App\Http\Controllers\LeadController::class, 'lead_cancel']);

Route::get('/purchase_order_list', [App\Http\Controllers\PurchaseOrderController::class, 'index']);
Route::get('/purchase_order_add', [App\Http\Controllers\PurchaseOrderController::class, 'purchase_order_add']);
Route::post('/add_purchase_order', [App\Http\Controllers\PurchaseOrderController::class, 'add_purchase_order']);
Route::get('/purchase_order_edit/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'purchase_order_edit']);
Route::post('/update_purchase_order', [App\Http\Controllers\PurchaseOrderController::class, 'update_purchase_order']);
Route::get('/purchase_order_generate_invoice/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'purchase_order_generate_invoice']);
Route::get('/purchase_order_project_list/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'purchase_order_project_list']);



Route::get('/service_category_list', [App\Http\Controllers\ServiceCategoryController::class, 'index']);
Route::get('/service_category_add', [App\Http\Controllers\ServiceCategoryController::class, 'service_category_add']);
Route::post('/add_service_category', [App\Http\Controllers\ServiceCategoryController::class, 'add_service_category']);
Route::get('/service_category_edit/{id}', [App\Http\Controllers\ServiceCategoryController::class, 'service_category_edit']);
Route::post('/update_service_category', [App\Http\Controllers\ServiceCategoryController::class, 'update_service_category']);
Route::get('/service_category_delete/{id}', [App\Http\Controllers\ServiceCategoryController::class, 'service_category_delete']);


Route::get('/service_list', [App\Http\Controllers\ServiceController::class, 'index']);
Route::get('/service_add', [App\Http\Controllers\ServiceController::class, 'service_add']);
Route::post('/add_service', [App\Http\Controllers\ServiceController::class, 'add_service']);
Route::get('/service_edit/{id}', [App\Http\Controllers\ServiceController::class, 'service_edit']);
Route::post('/update_service', [App\Http\Controllers\ServiceController::class, 'update_service']);
Route::get('/service_by_category/{id}', [App\Http\Controllers\ServiceController::class, 'service_by_category']);
Route::get('/service_delete/{id}', [App\Http\Controllers\ServiceController::class, 'service_delete']);



Route::get('/vendor_list', [App\Http\Controllers\VendorController::class, 'index']);

Route::get('/vendor_info/{id}', [App\Http\Controllers\VendorController::class, 'vendor_info']);
Route::get('/delete_vendor/{id}', [App\Http\Controllers\VendorController::class, 'vendor_delete']);

Route::get('/vendor_add', [App\Http\Controllers\VendorController::class, 'vendor_add']);
Route::post('/add_vendor', [App\Http\Controllers\VendorController::class, 'add_vendor']);

Route::get('/project_list', [App\Http\Controllers\ProjectController::class, 'index']);
Route::get('/project_add', [App\Http\Controllers\ProjectController::class, 'project_add']);
Route::post('/add_project', [App\Http\Controllers\ProjectController::class, 'add_project']);
Route::post('/get_projectByvendor_ajax', [App\Http\Controllers\ProjectController::class, 'get_projectByvendor_ajax']);
Route::get('/project_payment_info/{id}', [App\Http\Controllers\ProjectController::class, 'project_payment_info']);
Route::post('/project_milestone_add', [App\Http\Controllers\ProjectController::class, 'project_milestone_add']);

Route::get('/project_approve/{id}', [App\Http\Controllers\ProjectController::class, 'project_approve']);
Route::get('/project_cancel/{id}', [App\Http\Controllers\ProjectController::class, 'project_cancel']);

Route::post('/getCityBystateId', [App\Http\Controllers\CustomerController::class, 'getCityBystateId']);
Route::post('/getStateBycountryId', [App\Http\Controllers\CustomerController::class, 'getStateBycountryId']);


Route::get('/changepassword', [App\Http\Controllers\userController::class, 'changePassword']);
Route::POST('/updatepass', [App\Http\Controllers\userController::class, 'updatePassword']);

Route::get('staff-report/{id}', [App\Http\Controllers\userController::class, 'report'])
    ->name('staff.report');


Route::group(['middleware' => ['admin']], function ()
{
	Route::get('/staff_list', [App\Http\Controllers\userController::class, 'index']);
	Route::get('/staff_add', [App\Http\Controllers\userController::class, 'user_add']);
	Route::post('/add_user', [App\Http\Controllers\userController::class, 'add_user']);

    Route::get('assign-customers/{id}', [App\Http\Controllers\userController::class, 'assignCustomers'])
     ->name('assign.customers');

    Route::put('customer-unassign/{id}', [App\Http\Controllers\userController::class, 'unassign'])
    ->name('customer.unassign');

    Route::post('customer-assign', [App\Http\Controllers\userController::class, 'assign'])
    ->name('customer.assign');


});
