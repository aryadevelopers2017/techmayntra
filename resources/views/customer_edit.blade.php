@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
   <div class="main">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-8 p-r-0 title-margin-right">
               <div class="page-header">
                  <div class="page-title">
                     <h1>Edit New Client </h1>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 p-l-0 title-margin-left">
               <div class="page-header">
                  <div class="page-title">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Client </li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section id="main-content">
            <form action="{{ url('/update_customer') }}" id="formsubmit" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
               <input type="hidden" name="id" value="{{ $data['customer_info']->id }}">

               <div class="row">
                  <div class="col-lg-12">
                     <!-- Personal Details -->
                     <div class="card mb-4">
                        <div class="card-header mb-4">
                           <h4 class="mb-0">Personal Details</h4>
                        </div>
                        <div class="card-body">
                           <div class="basic-form">
                              <div class="row">
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label>Name</label>
                                       <input type="text" id="name" name="name" required class="form-control" placeholder="Name" value="{{ isset($data['customer_info']->name) ? $data['customer_info']->name : '' }}">
                                       <span id="errname" style="display:none;color: #ff0000;">Please Enter Name</span>
                                    </div>
                                    <div class="form-group">
                                       <label>Company Name</label>
                                       <input type="text" id="company_name" name="company_name" required class="form-control" placeholder="Company Name" value="{{ isset($data['customer_info']->company_name) ? $data['customer_info']->company_name : '' }}">
                                       <span id="errc_name" style="display:none;color: #ff0000;">Please Enter Company Name</span>
                                    </div>
                                    <div class="form-group">
                                       <label>Email Address</label>
                                       <input type="email" id="email" name="email" required class="form-control" value="{{ isset($data['customer_info']->email) ? $data['customer_info']->email : '' }}" placeholder="Email">
                                       <span id="erremail" style="display:none;color: #ff0000;">Please Enter Email</span>
                                       <span id="erralreadyemail" style="display:none;color: #ff0000;">Email Already Exists</span>
                                       <span id="errvalidemail" style="display:none;color: #ff0000;">Please Enter Valid Email</span>
                                    </div>
                                    <div class="form-group">
                                       <label>Mobile No</label>
                                       <input type="text" id="mobile" name="mobile" required minlength="10" maxlength="10" class="form-control number" value="{{ isset($data['customer_info']->mobile) ? $data['customer_info']->mobile : '' }}"  placeholder="Mobile">
                                       <span id="erremobile" style="display:none;color: #ff0000;">Please Enter Mobile No</span>
                                       <span id="errevalidmobile" style="display:none;color: #ff0000;">Enter Valid Mobile No</span>
                                    </div>
                                    <!-- NEW DROPDOWN: Assign Staff -->
                                    <div class="form-group">
                                       <label>Assign Staff</label>
                                       <select name="assigned_staff" id="assigned_staff" class="form-control select2">
                                          <option value="" selected disabled>Please Select Staff</option>
                                          @if(isset($data['staff_data']))
                                          @foreach($data['staff_data'] as $staff)
                                          @php
                                          $selected = '';
                                          if(isset($data['customer_info']->assigned_staff) && $data['customer_info']->assigned_staff == $staff->id) {
                                          $selected = 'selected';
                                          }
                                          @endphp
                                          <option value="{{ $staff->id }}" {{ $selected }}>{{ $staff->name }}</option>
                                          @endforeach
                                          @endif
                                       </select>
                                       <span id="errstaff" style="display:none;color: #ff0000;">Please Select Staff</span>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label>Address</label>
                                       <input type="text" id="address" name="address"  class="form-control" value="{{ isset($data['customer_info']->address) ? $data['customer_info']->address : '' }}"  placeholder="Address">
                                    </div>
                                    <div class="form-group">
                                       <label>Country</label>
                                       <select name="country" id="country" class="form-control select2" onchange="getStateByCountry();">
                                          <option value="" selected>Please Select Country</option>
                                          @foreach($data['country_data'] as $country)

                                           @php
                                          $selected = '';
                                          if(isset($data['customer_info']->country) && $data['customer_info']->country == $country->name) {
                                          $selected = 'selected';
                                          }
                                          @endphp

                                          <option value="{{ $country->id }}" {{ $selected }}>{{ $country->name }}</option>
                                          @endforeach
                                       </select>
                                    </div>

                                    <div class="form-group">
                                       <label>State</label>
                                       <select name="state" id="state" class="form-control select2" onchange="getcity();">
                                          <option value="">Please Select State</option>
                                       </select>
                                    </div>
                                    <div class="form-group" style="margin-top: 40px;">
                                       <label>City</label>
                                       <select id="city" name="city" class="form-control select2">
                                          <option value="{{ isset($lead_data->city) ? $lead_data->city : '' }}" selected>{{ isset($data->city) ? $data->city : 'Please Select City' }}</option>
                                          @if(isset($data['city_data']))
                                          @foreach($data['city_data'] as $city)
                                          @php
                                          $selected='';
                                          if(isset($data->city))
                                          {
                                          if(strtolower($data->city) == strtolower($city->name))
                                          {
                                          $selected='selected';
                                          }
                                          }
                                          @endphp
                                          <option value="{{ $city->id }}" {{ $selected }}>{{ $city->name }} </option>
                                          @endforeach
                                          @endif
                                       </select>
                                    </div>
                                    <div class="form-group">
                                       <label>GST No</label>
                                       <input type="text" id="gst_no" name="gst_no" value="{{ isset($data['customer_info']->gst_no) ? $data['customer_info']->gst_no : '' }}"  class="form-control" placeholder="GST No">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     @if(!empty($data['uploaded_documents']) && count($data['uploaded_documents']) > 0)
<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0">Uploaded Documents</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Document Type</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['uploaded_documents'] as $key => $doc)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}</td>
                    <td>
                        <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank"
                           class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                    <td>


                        <button type="button"
                                class="btn btn-sm btn-danger btn-delete-doc"
                                data-id="{{ $doc->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

                     <div class="card mb-4">
                        <div class="card-header mb-4">
                           <h4 class="mb-0">New Upload Documents</h4>
                        </div>
                        <div class="card-body">
                           <table class="table table-bordered" id="documents_table">
                              <thead>
                                 <tr>
                                    <th>Document Type</th>
                                    <th>Choose File</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td>
                                       <select name="documents[0][type]" class="form-control">
                                          <option value="" selected disabled>Select Document Type</option>
                                          @foreach($data['document_types'] as $doc)
                                          <option value="{{ $doc['slug'] }}">{{ $doc['name'] }}</option>
                                          @endforeach
                                       </select>
                                    </td>
                                    <td>
                                       <input type="file" name="documents[0][file]" class="form-control" />
                                    </td>
                                    <td>
                                       <button type="button" class="btn btn-success btn-add-document">+</button>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- TRAVEL DETAILS -->

                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="mb-3">Travel Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Departure Date -->
                                        <div class="form-group">
                                            <label>Departure Date :- <small> The date the Client  is leaving.</small></label>
                                            <input type="date" id="departure_date" name="departure_date" value="{{ isset($data['customer_info']->departure_date) ? $data['customer_info']->departure_date : '' }}" class="form-control">
                                        </div>

                                        <!-- Return Date -->
                                        <div class="form-group">
                                            <label>Return Date :- <small>The date the Client  returns.</small></label>
                                            <input type="date" id="return_date" name="return_date" value="{{ isset($data['customer_info']->return_date) ? $data['customer_info']->return_date : '' }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <!-- Travel Country -->
                                        <div class="form-group">
                                            <label>Travel Country</label>
                                            <select name="travel_country" id="travel_country" class="form-control select2" onchange="getTravelStateByCountry();">
                                                <option value="" >Please Select Country</option>
                                                @foreach($data['country_data'] as $country)

                                                   @php
                                                    $selected_taravel = '';
                                                    if(isset($data['customer_info']->travel_country) && $data['customer_info']->travel_country == $country->id) {
                                                    $selected_taravel = 'selected';
                                                    }
                                                    @endphp

                                                <option value="{{ $country->id }}" {{ $selected_taravel }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Travel State -->
                                        <div class="form-group">
                                            <label>Travel State</label>
                                            <select name="travel_state" id="travel_state" class="form-control select2" onchange="getTravelCityByState();">
                                                <option value="">Please Select State</option>
                                            </select>
                                        </div>

                                        <!-- Travel City -->
                                        <div class="form-group">
                                            <label>Travel City</label>
                                            <select name="travel_city" id="travel_city" class="form-control select2">
                                                <option value="">Please Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <!-- TRAVEL DETAILS -->
                     <button type="button" id="finalbtn" class="btn btn-primary">Submit</button>
                  </div>
               </div>
            </form>
         </section>
      </div>
   </div>
</div>
<script type="text/javascript">


    const selectedCountry = "{{ $data['customer_info']->country_id ?? '' }}";
    const selectedState   = "{{ $data['customer_info']->state_id ?? '' }}";
    const selectedCity    = "{{ $data['customer_info']->city_id ?? '' }}";

    const selectedTravelCountry = "{{ $data['customer_info']->travel_country ?? '' }}";
    const selectedTravelState   = "{{ $data['customer_info']->travel_state ?? '' }}";
    const selectedTravelCity    = "{{ $data['customer_info']->travel_city ?? '' }}";


$(document).ready(function () {

    $('#country').on('change', function () {
        getStateByCountry();
    });

    $('#state').on('change', function () {
        getcity();
    });

    // Auto trigger on edit
    if (selectedCountry) {
        $('#country').val(selectedCountry).trigger('change');
    }


    $('#travel_country').on('change', function () {
    getTravelStateByCountry();
    });

    $('#travel_state').on('change', function () {
        getTravelCityByState();
    });


//  auto select travel country
if (selectedTravelCountry) {
    $('#travel_country').val(selectedTravelCountry).trigger('change.select2');
}

});


function getStateByCountry()
{
    var country_id = $("#country").val();
    $("#state").html('');
    $("#city").html('<option value="">Please Select City</option>');

    $.ajax({
        type: 'POST',
        url: "{{ url('/getStateBycountryId') }}",
        data: {
            country_id: country_id,
            "_token": "{{ csrf_token() }}"
        },
        success: function (data)
        {
            if (data.state.status_code == 200)
            {
                var option = '<option value="">Please Select State</option>';
                $.each(data.state.data, function (index, value)
                {
                     let selected = (value.id == selectedState) ? 'selected' : '';
                    option += '<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';

                });
                $("#state").html(option);

                //  auto load city
                if (selectedState) {
                    $("#state").trigger('change');
                }
            }
        }
    });
}


    function getcity()
    {
        var state_id=$("#state").val();
        $("#city").html('');

        $.ajax({
            type : 'POST',
            url : "{{ url('/getCityBystateId') }}",
            data : {'state_id': state_id, "_token": "{{ csrf_token() }}"},
            success:function(data)
            {
                if(data.city.status_code == 200)
                {
                    var option='<option value="" selected disabled>Please Select City</option>';

                    $.each(data.city.data, function(index,value)
                    {
                            let selected = (value.id == selectedCity) ? 'selected' : '';
                            option += `<option value="${value.id}" ${selected}>${value.name}</option>`;
                    });

                    $("#city").html(option);
                }
            }
        });
    }

    $("#finalbtn").click(function()
    {
        var name=$("#name").val();
        var company_name=$("#company_name").val();
        var email=$("#email").val();
        var mobile=$("#mobile").val();
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        $("#name").parent().removeClass("has-error");
        $("#company_name").parent().removeClass("has-error");
        $("#email").parent().removeClass("has-error");
        $("#mobile").parent().removeClass("has-error");

        if(name=='' || name == null)
        {
            $("#errname").show(0).delay(3500).hide(0);
            $("#name").parent().addClass("has-error");
            $("#name").focus();
            return false;
        }

        if(company_name=='' || company_name == null)
        {
            $("#errc_name").show(0).delay(3500).hide(0);
            $("#company_name").parent().addClass("has-error");
            $("#company_name").focus();
            return false;
        }

        if(email=='' || email == null)
        {
            $("#erremail").show(0).delay(3500).hide(0);
            $("#email").parent().addClass("has-error");
            $("#email").focus();
            return false;
        }
        else if(!regex.test(email))
        {
            $("#errvalidemail").show(0).delay(3500).hide(0);
            $("#email").parent().addClass("has-error");
            $("#email").focus();
            return false;
        }

        if(mobile=='' || mobile == null)
        {
            $("#erremobile").show(0).delay(3500).hide(0);
            $("#mobile").parent().addClass("has-error");
            $("#mobile").focus();
            return false;
        }
        else if(mobile.length!=10)
        {
            $("#errevalidmobile").show(0).delay(3500).hide(0);
            $("#mobile").parent().addClass("has-error");
            $("#mobile").focus();
            return false;
        }

        $("#formsubmit").submit();
    });

    $(".number").on('keypress focusout', function(event)
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
</script>


<script>
let documentIndex = 1;

$(document).on('click', '.btn-add-document', function() {
    let row = `<tr>
        <td>
            <select name="documents[${documentIndex}][type]" class="form-control">
                <option value="" selected disabled>Select Document Type</option>
                @foreach($data['document_types'] as $doc)
                    <option value="{{ $doc['slug'] }}">{{ $doc['name'] }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="file" name="documents[${documentIndex}][file]" class="form-control" />
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-remove-document">-</button>
        </td>
    </tr>`;
    $('#documents_table tbody').append(row);
    documentIndex++;
});

$(document).on('click', '.btn-remove-document', function() {
    $(this).closest('tr').remove();
});
</script>

<script>

function getTravelStateByCountry() {
    var country_id = $("#travel_country").val();
    $("#travel_state").html('<option value="">Please Select State</option>');
    $("#travel_city").html('<option value="">Please Select City</option>');

    $.ajax({
        type: 'POST',
        url: "{{ url('/getStateBycountryId') }}",
        data: {
            country_id: country_id,
            "_token": "{{ csrf_token() }}"
        },
        success: function (data) {
            if (data.state.status_code == 200) {
                var option = '<option value="">Please Select State</option>';
                  $.each(data.state.data, function (index, value) {
                    let selected = (value.id == selectedTravelState) ? 'selected' : '';
                    option += `<option value="${value.id}" ${selected}>${value.name}</option>`;
                });

                $("#travel_state").html(option).trigger('change.select2');

                //  auto load city
                if (selectedTravelState) {
                    $("#travel_state").trigger('change');
                }
            }
        }
    });
}

function getTravelCityByState() {
    var state_id = $("#travel_state").val();
    $("#travel_city").html('<option value="">Please Select City</option>');

    $.ajax({
        type: 'POST',
        url: "{{ url('/getCityBystateId') }}",
        data: { state_id: state_id, "_token": "{{ csrf_token() }}" },
        success: function (data) {
            if (data.city.status_code == 200) {
                var option = '<option value="">Please Select City</option>';
                $.each(data.city.data, function(index,value)
                    {
                            let selected = (value.id == selectedTravelCity) ? 'selected' : '';
                            option += `<option value="${value.id}" ${selected}>${value.name}</option>`;
                    });
                $("#travel_city").html(option).trigger('change.select2');
            }
        }
    });
}


$(document).on('click', '.btn-delete-doc', function () {
    let docId = $(this).data('id');

    if (!confirm('Are you sure you want to delete this document?')) return;

    $.ajax({
        type: 'POST',
        url: "{{ route('customer.document.delete') }}",
        data: {
            id: docId,
            _token: "{{ csrf_token() }}"
        },
        success: function () {
            location.reload();
        }
    });
});


</script>






@endsection
