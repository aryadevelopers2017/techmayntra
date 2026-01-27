<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'company_name', 'address', 'email', 'mobile', 'city', 'state', 'status','assigned_staff','country','departure_date','return_date','travel_country','travel_state','travel_city'];

    public static function customer_list()
    {
    	$data=Customer::select('id', 'name', 'company_name', 'address', 'city', 'state', 'email', 'mobile')->where('status', 0)->orderBy('id', 'DESC')->get();
    	return $data;
    }

    public static function checkemail($request)
    {
    	$data=Customer::where(['email'=>strtolower($request->email)])->get();
    	return $data;
    }

    public static function get_CustomerByid($id)
    {
        $data=Customer::find($id);



        //  Convert country name → ID
        $country = DB::table('country')
            ->where('name', $data->country)
            ->first();

        $state = DB::table('states')
            ->where('name', $data->state)
            ->first();

        $city = DB::table('city')
            ->where('name', $data->city)
            ->first();

        $data->country_id = $country->id ?? null;
        $data->state_id   = $state->id ?? null;
        $data->city_id    = $city->id ?? null;



        //  Convert country name → ID
        $travel_country = DB::table('country')
            ->where('name', $data->travel_country)
            ->first();

        $travel_state = DB::table('states')
            ->where('name', $data->travel_state)
            ->first();

        $travel_city = DB::table('city')
            ->where('name', $data->travel_city)
            ->first();

        $data->travel_country_id = $travel_country->id ?? null;
        $data->travel_state_id   = $travel_state->id ?? null;
        $data->travel_city_id    = $travel_city->id ?? null;

        return $data;
    }

    public static function remove_customer($id)
    {
        $data=Customer::find($id);
        $data->status=1;

        $data->update();

        return $data;
    }

    public static function add_customer($request)
    {
        $customer =new Customer();

        $customer->name=$request->name;
        $customer->company_name=$request->company_name;
        $customer->email=$request->email;
        $customer->mobile=$request->mobile;
        $customer->address=isset($request->address) ? $request->address : '';
        $customer->city=isset($request->city) ? $request->city : '';
        $customer->state=isset($request->state) ? $request->state : '';
        $customer->gst_no=isset($request->gst_no) ? $request->gst_no : '';

         $customer->country = $request->country ?? null;

         // Assigned staff
    $customer->assigned_staff = $request->assigned_staff ?? null;

      // Travel details
    $customer->departure_date = $request->departure_date ?? null;
    $customer->return_date = $request->return_date ?? null;
    $customer->travel_country = $request->travel_country ?? null;
    $customer->travel_state = $request->travel_state ?? null;
    $customer->travel_city = $request->travel_city ?? null;

        $customer->save();


          if ($request->has('documents')) {

                foreach ($request->documents as $doc) {

                    if (!isset($doc['file'])) {
                        continue;
                    }

                    $path = $doc['file']->store('customer_documents', 'public');

                    CustomerDocument::create([
                        'customer_id' => $customer->id,
                        'document_type' => $doc['type'],
                        'file_path' => $path
                    ]);
                }
            }


        return $customer;
    }

    public static function update_customer($request)
{
    $customer = Customer::find($request->id);

    if (!$customer) {
        return null;
    }

    $customer->name = $request->name;
    $customer->company_name = $request->company_name;
    $customer->email = $request->email;
    $customer->mobile = $request->mobile;
    $customer->address = $request->address ?? '';
    $customer->city = $request->city ?? '';
    $customer->state = $request->state ?? '';
    $customer->country = $request->country ?? '';
    $customer->gst_no = $request->gst_no ?? null;

    // Assigned staff
    $customer->assigned_staff = $request->assigned_staff ?? null;

    // Travel details
    $customer->departure_date = $request->departure_date ?? null;
    $customer->return_date = $request->return_date ?? null;
    $customer->travel_country = $request->travel_country ?? null;
    $customer->travel_state = $request->travel_state ?? null;
    $customer->travel_city = $request->travel_city ?? null;

    $customer->save();

    // Upload NEW documents (do NOT delete old ones)
    if ($request->has('documents')) {
        foreach ($request->documents as $doc) {
            if (!isset($doc['file'])) continue;

            $path = $doc['file']->store('customer_documents', 'public');

            CustomerDocument::create([
                'customer_id' => $customer->id,
                'document_type' => $doc['type'],
                'file_path' => $path
            ]);
        }
    }

    return $customer;
}


	public static function getCountry()
    {
        $country = DB::table('country')->where(['status' => 0])->get();
        return $country;
    }

    public static function getState()
    {
        $state = DB::table('states')->where(['country_id' => 101])->get();
        return $state;
    }

    public static function getCity()
    {
        $state = DB::table('city')->where(['country_id' => 101])->get();
        return $state;
    }

    public static function getCityBystateId($id)
    {
        $state = DB::table('city')->where(['state_id' => $id])->get();
        return $state;
    }
	public static function getStateBycountryId($id)
    {
        $state = DB::table('states')->where(['country_id' => $id])->get();
        return $state;
    }

    public static function getStateName($id)
    {
        $state = DB::table('states')->where(['id' => $id])->get();
        return $state;
    }

    public static function getCountryName($id)
    {
        $country = DB::table('country')->where(['id' => $id])->get();
        return $country;
    }

     public static function getCityName($id)
    {
        $state = DB::table('city')->where(['id' => $id])->get();
        return $state;
    }

    public static function getStatedata($name)
    {
        $state = DB::table('states')->where(['name' => $name])->get();
        return $state;
    }
    public function staff()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_staff');
    }
public function getTravelCountryName()
{
    if (!$this->travel_country) {
        return '-';
    }

    $country = DB::table('country')
        ->where('id', $this->travel_country)
        ->value('name');

    return $country ?? '-';
}
public function getTravelStateName()
{
    if (!$this->travel_state) {
        return '-';
    }

    $state = DB::table('states')
        ->where('id', $this->travel_state)
        ->value('name');

    return $state ?? '-';
}
public function getTravelCityName()
{
    if (!$this->travel_city) {
        return '-';
    }

    $city = DB::table('city')
        ->where('id', $this->travel_city)
        ->value('name');

    return $city ?? '-';
}


public function getAssignedStaffName()
{
    if (!$this->assigned_staff) {
        return '-';
    }

    return optional($this->staff)->name ?? '-';
}

public function documents()
{
    return $this->hasMany(
        \App\Models\CustomerDocument::class,
        'customer_id'
    );
}

public function getDocuments()
{
    return $this->documents()->get();
}

public function getDocumentsByType()
{
    return $this->documents()
        ->select('document_type', 'file_path')
        ->get()
        ->groupBy('document_type');
}
public function getDocumentsGrouped()
{
    return DB::table('customer_documents')
        ->where('customer_id', $this->id)
        ->get()
        ->groupBy('document_type');
}


}
