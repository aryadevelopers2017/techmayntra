@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Vendor </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Vendor</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{ url('/add_vendor') }}" id="formsubmit" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="name" name="name" required class="form-control" placeholder="Name" value="{{ isset($data->name) ? $data->name : '' }}">
                                                    <span id="errname" style="display:none;color: #ff0000;">Please Enter Name</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Company Name</label>
                                                    <input type="text" id="company_name" name="company_name" required class="form-control" placeholder="Company Name">
                                                    <span id="errc_name" style="display:none;color: #ff0000;">Please Enter Company Name</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <input type="email" id="email" name="email" required class="form-control" value="{{ isset($data->email) ? $data->email : '' }}" placeholder="Email">
                                                    <span id="erremail" style="display:none;color: #ff0000;">Please Enter Email</span>
                                                    <span id="erralreadyemail" style="display:none;color: #ff0000;">Email Already Exists</span>
                                                    <span id="errvalidemail" style="display:none;color: #ff0000;">Please Enter Valid Email</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Mobile No</label>
                                                    <input type="text" id="mobile" name="mobile" required minlength="10" maxlength="10" class="form-control number" value="{{ isset($data->mobile) ? $data->mobile : '' }}"  placeholder="Mobile">
                                                    <span id="erremobile" style="display:none;color: #ff0000;">Please Enter Mobile No</span>
                                                    <span id="errevalidmobile" style="display:none;color: #ff0000;">Enter Valid Mobile No</span>
                                                </div>

                                                <div class="form-group">
                                                    <label>Service</label>
                                                    <select name="service_id" id="service_id" class="form-control select2">
                                                        <option value="">Please Select Service</option>
                                                        @foreach($data['services'] ?? [] as $service)
                                                            <option value="{{ $service->id }}">{{ $service->item_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>



                                                <div class="form-group">
                                                    <label>Rate & Rate Option</label>
                                                    <input
                                                        type="text"
                                                        name="rate_option"
                                                        class="form-control"
                                                        placeholder="e.g. Hourly / Per Day / Per Project"
                                                    >
                                                </div>


                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" id="address" name="address"  class="form-control" value="{{ isset($data->address) ? $data->address : '' }}"  placeholder="Address">
                                                </div>

                                                <div class="form-group">
                                                <label>Country</label>
                                                <select name="country" id="country" class="form-control select2" onchange="getStateByCountry();">
                                                    <option value="" selected>Please Select Country</option>
                                                    @foreach($data['country_data'] as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                </div>

                                                <!-- <div class="form-group">
                                                    <label>State</label>
                                                    <select name="state" id="state" onChange="getcity();" class="form-control select2">
                                                        <option value="" selected>Please Select State</option>
                                                        @foreach($data['state_data'] as $state)
                                                            @php
                                                                $selected='';

                                                                if(isset($data->state))
                                                                {
                                                                    if(strtolower($data->state) == strtolower($state->name))
                                                                    {
                                                                        $selected='selected';
                                                                    }
                                                                }
                                                            @endphp
                                                            <option value="{{ $state->id }}" {{ $selected }}>{{ $state->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div> -->


                                                 <div class="form-group">
                                       <label>State</label>
                                       <select name="state" id="state" class="form-control select2" onchange="getcity();">
                                          <option value="">Please Select State</option>
                                       </select>
                                    </div>

                                                <div class="form-group" >
                                                    <label>City</label>
                                                    <!-- <input type="text" id="city" name="city"  class="form-control" value="{{ isset($data->city) ? $data->city : '' }}"  placeholder="City"> -->
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
                                                    <input type="text" id="gst_no" name="gst_no"  class="form-control" placeholder="GST No">
                                                </div>
                                            </div>
                                        </div>


                                        <hr>
                                            <h4>Bank Details</h4>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Bank Name</label>
                                                        <input type="text" name="bank_name" class="form-control" placeholder="Bank Name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Account Holder Name</label>
                                                        <input type="text" name="account_holder_name" class="form-control" placeholder="Account Holder Name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Account Number</label>
                                                        <input type="text" name="account_number" class="form-control number" placeholder="Account Number">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>IFSC Code</label>
                                                        <input type="text" name="ifsc_code" class="form-control" placeholder="IFSC Code">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Branch Name</label>
                                                        <input type="text" name="branch_name" class="form-control" placeholder="Branch Name">
                                                    </div>
                                                </div>
                                            </div>



                                        <button type="button" id="finalbtn" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">



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
                    option += '<option value="'+value.id+'">'+value.name+'</option>';
                });
                $("#state").html(option);
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
                        option+='<option value="'+value.id+'">'+value.name+'</option>';
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
@endsection
