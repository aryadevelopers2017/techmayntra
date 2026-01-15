@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Vendor Receipt </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Vendor Receipt</li>
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
                                    @if(isset($data->id))
                                        <form action="{{ url('/update_purchase_order') }}" id="purchaseorderform" method="POST">
                                        <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
                                    @else
                                        <form action="{{ url('/add_purchase_order') }}" id="purchaseorderform" method="POST">
                                    @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Purchase Date </label>
                                                    @if(isset($data->purchase_date))
                                                        <input type="date" class="form-control" id="purchase_date" name="purchase_date" placeholder="Select Date" max="@php echo date('Y-m-d', strtotime($data->purchase_date)); @endphp" min="@php echo date('Y-m-01', strtotime($data->purchase_date)); @endphp" value="{{ isset($data->purchase_date) ? $data->purchase_date : '' }}" required>
                                                    @else
                                                        <input type="date" class="form-control" id="purchase_date" name="purchase_date" placeholder="Select Date" max="@php echo date('Y-m-d'); @endphp" min="@php echo date('Y-m-01'); @endphp" value="{{ isset($data->purchase_date) ? $data->purchase_date : '' }}" required>
                                                    @endif
                                                    <span id="errdate" style="display:none;color: #ff0000;">Please Enter Subject</span>
                                                </div>

                                                <div class="form-group">
                                                    <label>Company Name </label>
                                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name" value="{{ isset($data->company_name) ? $data->company_name : '' }}" required>
                                                    <span id="errcompany_name" style="display:none;color: #ff0000;">Please Enter Company Name</span>
                                                </div>

                                                <div class="form-group">
                                                    <label>Vendor Name </label>
                                                    <select name="vender_id" id="vender_id" class="form-control select2" required onchange="get_project_list();">
                                                        <option value="" selected disabled>Please Select vendor</option>
                                                        @foreach($data['vendor_list'] as $vendordata)
                                                            @if(isset($data->vender_id) && $data->vender_id == $vendordata->id)
                                                                <option value="{{ $vendordata->id}}" selected>{{ $vendordata->name}} - {{ $vendordata->company_name }}</option>
                                                            @else
                                                                <option value="{{ $vendordata->id}}">{{ $vendordata->name}} - {{ $vendordata->company_name }}</option>
                                                            @endif
                                                        @endforeach
                                                        @if(isset($data->vender_id))
                                                            @if($data->vender_id=='other')
                                                                <option value="other" selected>other</option>
                                                            @else
                                                                <option value="other">other</option>
                                                            @endif
                                                        @else
                                                            <option value="other">other</option>
                                                        @endif
                                                    </select>
                                                    <span id="errvendor_name" style="display:none;color: #ff0000;">Please Enter Vendor Name</span>
                                                </div>

                                                <div class="form-group" id="div_project">
                                                    <label>Select Project </label>
                                                    <select name="project_id" id="project_id" class="form-control select2" required>
                                                    @if(isset($data['project_list']))
                                                        <option value="" selected disabled>please select project</option>
                                                        @foreach($data['project_list'] as $project_data)
                                                            @if(isset($data->project_id) && $data->project_id == $project_data->id)
                                                                <option value="{{ $project_data->id}}" selected>{{ $project_data->quotation_title}}</option>
                                                            @else
                                                                <option value="{{ $project_data->id}}">{{ $project_data->quotation_title}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    </select>
                                                    <span id="errproject" style="display:none;color: #ff0000;">Please Select Project</span>
                                                </div>

                                                <div class="form-group" id="div_subject" style="display: none;">
                                                    <label>Subject </label>
                                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" value="{{ isset($data->subject) ? $data->subject : '' }}">
                                                    <span id="errsubject" style="display:none;color: #ff0000;">Please Enter Subject</span>
                                                </div>

                                                <div class="form-group">
                                                    <label>Product Name </label>
                                                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" value="{{ isset($data->product_name) ? $data->product_name : '' }}">
                                                    <span id="errproduct_name" style="display:none;color: #ff0000;">Please Enter Vendor Name</span>
                                                </div>

                                                <div class="form-group">
                                                    <label>Description </label>
                                                    <textarea class="form-control" id="description" name="description" rows="5" cols="100" required>{{ isset($data->description) ? $data->description : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Address </label>
                                                    <textarea class="form-control" id="address" name="address" rows="5" cols="100" required>{{ isset($data->address) ? $data->address : '' }}
                                                    </textarea>
                                                    <span id="erraddress" style="display:none;color: #ff0000;">Please Enter Address</span>
                                                </div>

                                                <div class="form-group">
                                                    <label>State </label>
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
                                                    <span id="errstate" style="display:none;color: #ff0000;">Please Enter State</span>
                                                </div>

                                                <div class="form-group" style="margin-top: 30px;">
                                                    <label>City </label>
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
                                                    <span id="errcity" style="display:none;color: #ff0000;">Please Enter City</span>
                                                </div>

                                                <div class="form-group">
                                                    <label>Pincode </label>
                                                    <input type="text" class="form-control number" id="pincode" name="pincode" placeholder="Enter Pincode" value="{{ isset($data->pincode) ? $data->pincode : '' }}" required>
                                                    <span id="errstate" style="display:none;color: #ff0000;">Please Enter Pincode</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status </label>
                                                    <div style="margin-left: 10px;">
                                                        <input type="radio" id="onhold_status" name="status" class="status" value="0" >&nbsp;&nbsp;On hold &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" id="accept_status" name="status" class="status" value="1">&nbsp;&nbsp;&nbsp;Accept &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="status" id="reject_status" name="status" value="2">&nbsp;&nbsp;&nbsp;Reject
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Amount </label>
                                                    <input type="text" class="form-control number" id="amount" name="amount" placeholder="Enter amount" placeholder="0" value="{{ isset($data->amount) ? $data->amount : '0' }}">
                                                    <span id="errproduct_name" style="display:none;color: #ff0000;">Please Enter Vendor Name</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div>
                                                        <input type="checkbox" id="gst" name="gst" value="1">&nbsp;&nbsp;GST
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="gst_data" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div>
                                                            <input type="checkbox" id="igst" name="igst" value="1">&nbsp;&nbsp;IGST
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>GST Percentage(%)</label>
                                                        <input type="text" class="form-control number1" id="gst_per" min="0" max="100" name="gst_per" placeholder="Enter GST Percentage" placeholder="0" value="{{ isset($data->gst_per) ? $data->gst_per : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Total Amount </label>
                                                    <input type="text" readonly class="form-control" id="total_amount" name="total_amount" placeholder="0" value="{{ isset($data->total_amount) ? $data->total_amount : '0' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Payment Mode </label>
                                                    <div style="margin-left: 10px;">
                                                        <input type="radio" id="cash" name="payment_mode" class="payment_mode" value="cash" >&nbsp;&nbsp;Cash &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" id="net_banking" name="payment_mode" class="payment_mode" value="Net Banking">&nbsp;&nbsp;&nbsp;Net Banking &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="payment_mode" id="mobile_app" name="payment_mode" value="Mobile Application">&nbsp;&nbsp;&nbsp;Mobile Application&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="payment_mode" id="upi" name="payment_mode" value="UPI">&nbsp;&nbsp;&nbsp;UPI
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" id="finalbtn" class="btn btn-primary">Submit</button>
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
<script>
    $( document ).ready(function()
    {
        $('.select2-container').css('display', 'inline-table');
        $('.tox-notifications-container').css('display', 'none !important');

        $('.summernote').summernote();
    });

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

    function get_project_list()
    {
        var vender_id=$("#vender_id").val();

        $("#div_subject").css('display', 'none');
        $("#div_project").css('display', 'none');
        $("#subject").prop('required', false);
        $("#project_id").prop('required', false);

        if(vender_id=='other')
        {
            $("#div_subject").css('display', 'block');
            $("#subject").prop('required', true);
        }
        else
        {
            $.ajax({
                method: "POST",
                url: "{{ url('/get_projectByvendor_ajax') }}",
                data:{'id':vender_id,"_token": "{{ csrf_token() }}"},
                success: function(result)
                {
                    var data=JSON.parse(result);
                    var res=data.data;
                    var project_data='';
                    res.forEach(function(item)
                    {
                        project_data+='<option value="'+item["id"]+'">'+item["quotation_title"]+'</option>';
                    });

                    $("#div_project").css('display', 'block');
                    $("#project_id").prop('required', true);
                    $("#project_id").html('');
                    $("#project_id").html(project_data);
                }
            });
        }
    }

    $(".number").on('keypress keyup focusout', function()
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
        this.value=this.value.replace('.','');
        calculate_amount();
    });

    $(".number1").on('keypress keyup focusout', function()
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
        calculate_amount();
    });

    function calculate_amount(argument)
    {
        var amount=$("#amount").val();
        var tamt=amount;

        if(parseFloat(amount)<0 || amount=='')
        {
            $("#amount").val(0);
            amount=0;
        }

        if ($("#gst").is(":checked"))
        {
            var gst_per=$("#gst_per").val();

            if(parseFloat(gst_per)>0 && parseFloat(gst_per)<100)
            {
                var gst_amt=((parseFloat(amount)*parseFloat(gst_per))/100).toFixed(2);
                tamt=(parseFloat(amount)+parseFloat(gst_amt)).toFixed(2);
            }
            else
            {
                $("#gst_per").val(0);
            }
        }

        $("#total_amount").val(tamt);
    }

    $("#gst").change(function()
    {
        if ($("#gst").is(":checked"))
        {
            $("#gst_data").css('display', 'block');
        }
        else
        {
            $("#gst_data").css('display', 'none');
            $("#igst").prop("checked",false);
            $("#gst_per").val(0);
        }

        calculate_amount();
    });
</script>
@if(isset($data->gst))
    <script>
        $( document ).ready(function()
        {
            var igst="{{ $data->igst }}";
            var gst="{{ $data->gst }}";
            if(gst==1)
            {
                $("#gst").prop('checked', true);
                $("#gst_data").css('display', 'block');

                if(igst==1)
                {
                    $("#igst").prop('checked', true);
                }
            }
        });
    </script>
@endif
@if(isset($data->status))
    <script>
        $( document ).ready(function()
        {
            var my_status="{{ $data->status }}";
            $(".status").each(function ()
            {
                var status=$(this).val();

                if(my_status==status)
                {
                    $(this).prop('checked', true);
                }
            });
        });
    </script>
@endif

@if(isset($data->vender_id))
    <script>
        $( document ).ready(function()
        {
            var vender_id="{{ $data->vender_id }}";

            $("#div_subject").css('display', 'none');
            $("#div_project").css('display', 'none');
            $("#subject").prop('required', false);
            $("#project_id").prop('required', false);

            if(vender_id=='other')
            {
                $("#div_subject").css('display', 'block');
                $("#subject").prop('required', true);
            }
            else
            {
                $("#div_project").css('display', 'block');
                $("#project_id").prop('required', false);
            }
        });
    </script>
@endif

@if(isset($data->payment_mode))
    <script>
        $( document ).ready(function()
        {
            var payment_mode="{{ $data->payment_mode }}";
            $(".payment_mode").each(function ()
            {
                var pay_mod=$(this).val();

                if(payment_mode==pay_mod)
                {
                    $(this).prop('checked', true);
                }
            });
        });
    </script>
@endif
@endsection
