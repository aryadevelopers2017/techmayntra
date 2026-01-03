@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Project </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project</li>
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
                                    <form action="{{ url('/add_project') }}" id="formsubmit" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Select Quotation</label>
                                                    <select class="form-control select2" id="quotation_id" name="quotation_id" required onchange="quotationchange();">
                                                        <option value="" selected disabled>Select Quotation</option>
                                                        @foreach($data['quotation'] as $quot_item)
                                                            <option value="{{ $quot_item->id }}" data-id="{{ $quot_item->title }}" data-price="{{ $quot_item->total_amount }}" data-c_id="{{ $quot_item->c_id }}" data-c_name="{{ $quot_item->customer_name }}" data-work_day="{{ $quot_item->working_days }}" >{{ $quot_item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="errquotation_id" style="display:none;color: #ff0000;">Please Select Quotation</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" id="quotation_title" name="quotation_title" required class="form-control" placeholder="Title" value="{{ isset($data->quotation_title) ? $data->quotation_title : '' }}">
                                                    <span id="errtitle" style="display:none;color: #ff0000;">Please Enter Title</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Quotation Price</label>
                                                    <input type="text" id="quotation_price" name="quotation_price" required readonly class="form-control number" placeholder="Quotation Price" value="{{ isset($data->quotation_price) ? $data->quotation_price : '' }}">
                                                    <span id="errquotation_price" style="display:none;color: #ff0000;">your quotation price is 0, So please select valid quotation</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Select Customer</label>
                                                    <select class="select2 form-control" id="customer_id" name="customer_id" required>
                                                        <option value="" selected disabled>Please select customer</option>
                                                    </select>
                                                    <span id="errcustomer_id" style="display:none;color: #ff0000;">Please Select Customer</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input type="date" id="start_date" name="start_date" min="{{ date('Y-m-d', strtotime(date('Y-m-d'). '-3 days')) }}" required class="form-control datepicker" placeholder="Start Date">
                                                    <span id="err_start_date" style="display:none;color: #ff0000;">please select start date</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Due Date</label>
                                                    <input type="date" id="due_date" step!=7 min="{{ date('Y-m-d') }}" name="due_date" required class="form-control datepicker" placeholder="Due Date">
                                                    <span id="err_due_date" style="display:none;color: #ff0000;">please select due date</span>
                                                    <span id="err_due_date_notvalid" style="display:none;color: #ff0000;">please select due date after start date</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Select Vendor</label>
                                                    <select class="form-control select2" id="vendor_id" name="vendor_id" required>
                                                        <option value="" selected disabled>Select Vendor</option>
                                                        @foreach($data['vendor'] as $vendor)
                                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="errvendor_id" style="display:none;color: #ff0000;">Please Select Vendor</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Vendor Price</label>
                                                    <input type="text" id="vendor_price" name="vendor_price" required class="form-control" placeholder="Vendor Price" value="{{ isset($data->vendor_price) ? $data->vendor_price : '' }}">
                                                    <span id="errvendor_price" style="display:none;color: #ff0000;">Please Enter Vendor Price</span>
                                                    <span id="errvendor_price_less" style="display:none;color: #ff0000;">Please Enter Vendor Price less then quotation price</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Remarks</label>
                                                    <input type="text" id="remarks" name="remarks" class="form-control" placeholder="Remarks" value="{{ isset($data->remarks) ? $data->remarks : '' }}">
                                                    <span id="errtitle" style="display:none;color: #ff0000;">Please Enter Remarks</span>
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
<script>
    var working_days=0;
    $(".number").on('keypress focusout', function(event)
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    $("#finalbtn").click(function(event)
    {
        var quotation_id=$("#quotation_id").val();
        var quotation_price=$("#quotation_price").val();
        var customer_id=$("#customer_id").val();
        var vendor_id=$("#vendor_id").val();
        var vendor_price=$("#vendor_price").val();
        var start_date=$("#start_date").val();
        var due_date=$("#due_date").val();

        if(quotation_id=='')
        {
            $("#errquotation_id").show(0).delay(2500).hide(0);
            $("#quotation_id").focus();
            return false;
        }

        if(quotation_price=='' || quotation_price==0)
        {
            $("#errquotation_price").show(0).delay(2500).hide(0);
            $("#quotation_id").focus();
            return false;
        }

        if(customer_id=='')
        {
            $("#errcustomer_id").show(0).delay(2500).hide(0);
            $("#customer_id").focus();
            return false;
        }

        if(vendor_id=='')
        {
            $("#errvendor_id").show(0).delay(2500).hide(0);
            $("#vendor_id").focus();
            return false;
        }

        if(parseFloat(vendor_price)>=parseFloat(quotation_price))
        {
            $("#errvendor_price_less").show(0).delay(2500).hide(0);
            $("#vendor_price").focus();
            return false;   
        }

        if(start_date>due_date)
        {
            $("#err_due_date_notvalid").show(0).delay(3500).hide(0);
            $("#due_date").focus();
            return false;
        }

        $("#formsubmit").submit();

    });

    function quotationchange()
    {
        var quot_title=$("#quotation_id").find(':selected').attr('data-id');
        var quot_price=$("#quotation_id").find(':selected').attr('data-price');
        var c_id=$("#quotation_id").find(':selected').attr('data-c_id');
        var c_name=$("#quotation_id").find(':selected').attr('data-c_name');
        var work_day=$("#quotation_id").find(':selected').attr('data-work_day');

        var start_date=$("#start_date").val();

        working_days=work_day;

        var customer_data='<option value="'+c_id+'" selected>'+c_name+'</option>';

        $("#quotation_title").val(quot_title);
        $("#quotation_price").val(quot_price);
        $("#customer_id").html('');
        $("#customer_id").html(customer_data);

        if(start_date!='')
        {
            datecalculate(start_date);
        }
    }

    $("#vendor_price").focusout(function(event)
    {
        var vendor_price=$("#vendor_price").val();
        var quotation_price=$("#quotation_price").val();

        if(quotation_price=='' || quotation_price==0)
        {
            $("#errquotation_price").show(0).delay(3500).hide(0);
            $("#quotation_id").focus();
            return false;
        }

        if(vendor_price=='' || vendor_price==0)
        {
            $("#errvendor_price").show(0).delay(3500).hide(0);
            $("#vendor_price").focus();
            return false;
        }

        if(parseFloat(vendor_price)>=parseFloat(quotation_price))
        {
            $("#errvendor_price_less").show(0).delay(3500).hide(0);
            $("#vendor_price").focus();
            return false;
        }
    });

    $("#start_date").focusout(function ()
    {
        var start_date=$("#start_date").val();
        var due_date=$("#due_date").val();

        if(start_date=='' || start_date==null || start_date=='undefine')
        {
            $("#err_start_date").show(0).delay(3500).hide(0);
            $("#start_date").focus();
            return false;
        }

        $("#due_date").attr('min', start_date);

        // datecalculate(start_date);
    });

    /*function datecalculate(start_date)
    {
        var new_date=new Date(start_date);
        var start_date=new Date(start_date);
        var days=parseInt(working_days)+1;
        var start_week_day=start_date.getDay();
        new_date.setDate(new_date.getDate() + days);
        var addays=0;

        if(parseInt(start_week_day)==0)
        {
            addays=2;
        }
        else if(parseInt(start_week_day)==6 || parseInt(start_week_day)==5)
        {
            addays=3;
        }

        if(parseInt(addays)>0)
        {
            start_date.setDate(start_date.getDate() + addays);
            new_date.setDate(new_date.getDate() + addays);
        }

        var end_week_day=new_date.getDay();

        var onejan = new Date(start_date.getFullYear(), 0, 1);

        var start_week_no= Math.ceil((((new Date(start_date) - onejan) / 86400000) + onejan.getDay() + 1) / 7)+1;
        var end_week_no= Math.ceil((((new Date(new_date) - onejan) / 86400000) + onejan.getDay() + 1) / 7)-1;

        if(parseInt(end_week_day)==6 || parseInt(end_week_day)==0)
        {
            end_week_no=parseInt(end_week_no)+1;
        }
        else
        {
            end_week_no=parseInt(end_week_no)-1;
        }

        var totaldays=(parseInt(end_week_no)-parseInt(start_week_no))*2;
        if(parseInt(totaldays)>0)
        {
            new_date.setDate(new_date.getDate() + totaldays);
        }

        var check_days=new_date.getDay();
        var new_days=0;

        if(parseInt(check_days)==0)
        {
            new_days++;
        }
        else if(parseInt(check_days)==6)
        {
            new_days=new_days+2;
        }

        if(parseInt(new_days)>0)
        {
            new_date.setDate(new_date.getDate() + new_days);
        }

        var end_date = new Date(new_date);

        var due_date=end_date.getFullYear() + '-' + ("0" + (end_date.getMonth() + 1)).slice(-2) + '-' + ("0" + end_date.getDate()).slice(-2);
        
        $("#due_date").val(due_date);
    }*/

    $("#due_date").focusout(function ()
    {
        var start_date=$("#start_date").val();
        var due_date=$("#due_date").val();

        if(start_date=='' || start_date==null || start_date=='undefine')
        {
            $("#err_start_date").show(0).delay(3500).hide(0);
            $("#start_date").focus();
            return false;
        }

        if(due_date=='' || due_date==null || due_date=='undefine')
        {
            $("#err_due_date").show(0).delay(3500).hide(0);
            $("#due_date").focus();
            return false;
        }

        if(start_date>due_date)
        {
            $("#err_due_date_notvalid").show(0).delay(3500).hide(0);
            $("#due_date").focus();
            return false;
        }
    });

    $(document).ready(function ()
    {
        // 
    });
</script>
@endsection
