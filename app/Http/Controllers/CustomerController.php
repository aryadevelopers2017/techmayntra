<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\CustomerServiceProvider;
use App\Models\Customer;
use App\Models\User;
use DB;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index()
    {
    	$data=CustomerServiceProvider::customer_list();

    	return view('customer_list')->with('customer', $data['data']);
    }

    public static function customer_add()
    {
        $data=[];
           $data['country_data'] = Customer::getCountry();
        $data['state_data']=Customer::getState();

         $data['staff_data'] = User::all(); // or any query to get active staff

          // Document types from service provider
    $data['document_types'] = CustomerServiceProvider::getDocumentTypes();

    	return view('customer_add')->with('data', $data);
    }

    public static function customer_checkemail(Request $request)
    {
        $data=CustomerServiceProvider::checkemail($request);
        if(count($data['data'])<=0)
        {
            return 'success';
        }
        return 'fail';
    }

    public static function add_customer(Request $request)
    {

        // dd( $request->all());

        $customer=CustomerServiceProvider::add_customer($request);

        if($customer['status_code']==200)
        {
            $status='success';
        }
        else
        {
            $status='fail';
        }
        $message=$customer['message'];

        return redirect('/customer')->with($status, $message);
    }

public static function update_customer(Request $request)
{
    // dd($request->all()); // remove after testing

    $customer = CustomerServiceProvider::update_customer($request);

    if ($customer['status_code'] == 200) {
        $status = 'success';
    } else {
        $status = 'fail';
    }

    return redirect('/customer')->with($status, $customer['message']);
}



    public static function customer_info($id)
    {
        $data=CustomerServiceProvider::get_customer_info($id);

        return view('customer_info')->with('data', $data['data']);
    }

    public static function delete_customer($id)
    {
        $data=CustomerServiceProvider::delete_customer($id);

        return redirect('/customer');
    }

    public static function edit_customer($id)
    {

        $data=[];
        $data['country_data'] = Customer::getCountry();
        $data['state_data']=Customer::getState();

        $data['staff_data'] = User::all(); // or any query to get active staff

          // Document types from service provider
        $data['document_types'] = CustomerServiceProvider::getDocumentTypes();

        $customer_info = CustomerServiceProvider::get_customer_info($id);

         $data['customer_info'] = $customer_info['data'] ;

         $data['uploaded_documents'] = CustomerServiceProvider::getCustomerDocuments($id);

        //  dd($data['uploaded_documents']);

                return view('customer_edit')->with('data', $data);

    }

    public static function getCityBystateId(Request $request)
    {
        $data=CustomerServiceProvider::getCityBystateId($request->state_id);

        return response()->json(array('city'=> $data), 200);
    }
	public static function getStateBycountryId(Request $request)
    {
        $data=CustomerServiceProvider::getStateBycountryId($request->country_id);

        return response()->json(array('state'=>  $data), 200);
    }

 public function deleteDocument(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer'
            ]);

            // Get document
            $document = DB::table('customer_documents')
                ->where('id', $request->id)
                ->first();

            if (!$document) {
                return response()->json([
                    'status' => false,
                    'message' => 'Document not found'
                ]);
            }

            // Delete file from storage (if exists)
            if (!empty($document->file_path) && file_exists(public_path($document->file_path))) {
                unlink(public_path($document->file_path));
            }

            // Delete DB record
            DB::table('customer_documents')
                ->where('id', $request->id)
                ->delete();

            return response()->json([
                'status' => true,
                'message' => 'Document deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }



}
