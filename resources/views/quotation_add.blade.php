<style type="text/css">
    .modal-backdrop
    {
        /*background-color: transparent !important;*/
        background-color: rgba(0, 0, 0, 0.4) !important;;
        -webkit-transition: 0.5s;
        overflow: auto;
        transition: all 0.3s linear;
    }
</style>
@extends('layouts.Admin.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Quotation </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Quotation</li>
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
                                    @php
                                        $currency_data=$details_array['currency_data'];
                                    @endphp
                                    @if(isset($details_array['quotation_id']))
                                        <form action="{{ url('/update_quotation') }}" id="quotationform" method="POST">
                                            <input type="hidden" name="id" id="id" value="{{ $details_array['quotation_id'] }}" />
                                    @else
                                        <form action="{{ url('/add_quotation') }}" id="quotationform" method="POST">
                                    @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" name="currency_id" value="{{ $currency_data->id }}" />
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Title </label>
                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ isset($details_array['title']) ? $details_array['title'] : ''}}">
                                                    <span id="errtitle" style="display:none;color: #ff0000;">Please Enter Title</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Select Customer </label>
                                                    <select id="c_id" name="c_id" class="form-control select2" required>
                                                        <option value="">Please Select Customer</option>
                                                        @foreach($details_array['customer_data'] as $customer)
                                                            @if(isset($details_array['customer_id']) && $details_array['customer_id'] == $customer->id)
                                                                <option value="{{ $customer->id }}" selected>{{ $customer->name }} - {{ $customer->company_name }}</option>
                                                            @else
                                                                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->company_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span id="errname" style="display:none;color: #ff0000;">Please Select Customer</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label>Select Company Branch Address</label>
                                            <select id="company_address" name="company_address" class="form-control select2" required>
                                                <option value="" disabled>Please Company Address</option>
                                                @php
                                                    $i=0;
                                                @endphp
                                                @foreach($details_array['company_address_data'] as $address_data)
                                                    @if(isset($details_array['customer_id']) && $details_array['company_address_id']== $address_data->id)
                                                        <option value="{{ $address_data->id }}" selected>{{ $address_data->address }} - {{ $address_data->city }} - {{ $address_data->state }}</option>
                                                    @else
                                                        <option value="{{ $address_data->id }}" @if($i==0) selected @endif>{{ $address_data->address }} - {{ $address_data->city }} - {{ $address_data->state }}</option>
                                                    @endif
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            </select>
                                            <span id="errname" style="display:none;color: #ff0000;">Please Select Company</span>
                                        </div>
                                        <div class="row form-group">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Item</button>
                                        </div>
                                        <label>Item</label>
                                        <div class="form-group" id="items"></div>
                                        @if(isset($details_array['quotation_id']))
                                            @foreach($details_array['item_data'] as $item)
                                                @if($item->price>0)
                                                    <div class="row form-group" id="{{ $item->id }}">
                                                        @if(isset($item->item_id))
                                                            <input type="checkbox" class="item" id="item[]" name="item[]" value="{{ $item->id }}" checked hidden>
                                                        @else
                                                            <input type="checkbox" class="item" id="item[]" name="item[]" value="{{ $item->id }}" hidden>
                                                        @endif
                                                        <div class="col-md-1">
                                                            <label for="name"><b>{{ $item->item_name }}</b></label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <textarea type="textarea" class="summernote" placeholder="{{ $item->item_name }} Description" id="item_desc_{{ $item->id }}" name="item_desc_{{ $item->id }}" rows="5" cols="40">{{ $item->desc }}</textarea>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control number1" id="item_qty_{{ $item->id }}" name="item_qty_{{ $item->id }}" placeholder="Qty" value="{{ $item->qty }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control number" id="item_price_{{ $item->id }}" name="item_price_{{ $item->id }}" placeholder="Price ({{ $currency_data->symbol }})" value="{{ $item->price}}">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger" id="btn_'+id+'" onclick="removefun('{{ $item->id }}')" name="btn_'+id+'" >Remove</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        <span id="erritem" style="display: none; color: #ff0000;">Please Select item</span>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group row mt-4">
                                                    <div class="col-md-3">
                                                        <input type="checkbox" id="gst"  name="gst" value="1">&nbsp;&nbsp;&nbsp;<label>GST</label>
                                                    </div>
                                                </div>
                                                
                                                <div id="gst_div" style="display: none;margin-left: -7px !important;">
                                                    <div class="form-group">
                                                        <div class="col-md-3 mt-5">
                                                            <input type="checkbox" id="igst" name="igst" value="1">&nbsp;&nbsp;&nbsp;<label>IGST</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>GST (%)</label>
                                                        <input type="text" class="form-control number" id="gst_per" value="{{ isset($details_array['gst_per']) ? $details_array['gst_per'] : 18 }}" max="100" min="0" name="gst_per" placeholder="GST (%)" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Discount (%)</label>
                                                    <input type="text" class="form-control number" id="discount" value="{{ isset($details_array['discount']) ? $details_array['discount'] : '' }}" min="0" max="100" name="discount" placeholder="0" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Amount ({{ $currency_data->symbol }})</label>
                                                    <input type="text" class="form-control number" id="total_amount" name="total_amount" readonly disabled value="{{ isset($details_array['total_amount']) ? $details_array['total_amount'] : '0'}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Working Days </label>
                                                    <input type="text" class="form-control number" id="working_days" name="working_days" value="{{ isset($details_array['working_days']) ? $details_array['working_days'] : '0'}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Technology </label>
                                                    <textarea class="summernote" id="technology" name="technology">
                                                        @php
                                                            if(isset($details_array['technology']))
                                                            {
                                                                if($details_array['technology']!='')
                                                                {
                                                                    echo $details_array['technology'];
                                                                }
                                                                else
                                                                {
                                                                    echo $details_array['company_data'][0]->technology;
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo $details_array['company_data'][0]->technology;
                                                            }
                                                        @endphp
                                                        </textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Mile Stone </label>
                                                    <textarea class="summernote" id="milestone" name="milestone">
                                                        @php
                                                            if(isset($details_array['milestone']))
                                                            {
                                                                if($details_array['milestone']!='')
                                                                {
                                                                    echo $details_array['milestone'];
                                                                }
                                                                else
                                                                {
                                                                    echo $details_array['company_data'][0]->milestone;
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo $details_array['company_data'][0]->milestone;
                                                            }
                                                        @endphp
                                                        </textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    @if(isset($details_array['terms_conditions_flag']) && $details_array['terms_conditions_flag'] == 1)
                                                        <input type="checkbox" id="terms_conditions_flag" name="terms_conditions_flag" value="1" checked>&nbsp;&nbsp;&nbsp;<label>Terms & condition</label>
                                                        <div id="term">
                                                            <textarea class="summernote" id="terms_conditions" name="terms_conditions">
                                                                @php
                                                                    if(isset($details_array['terms_conditions']))
                                                                    {
                                                                        if($details_array['terms_conditions']!='')
                                                                        {
                                                                            echo $details_array['terms_conditions'];
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $details_array['company_data'][0]->terms_conditions;
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $details_array['company_data'][0]->terms_conditions;
                                                                    }
                                                                @endphp
                                                            </textarea>
                                                        </div>
                                                    @else
                                                        <input type="checkbox" id="terms_conditions_flag" name="terms_conditions_flag" value="1">&nbsp;&nbsp;&nbsp;<label>Terms & condition</label>
                                                        <div id="term" style="display: none;">
                                                            <textarea class="summernote" id="terms_conditions" name="terms_conditions">
                                                                @php
                                                                    if(isset($details_array['terms_conditions']))
                                                                    {
                                                                        if($details_array['terms_conditions']!='')
                                                                        {
                                                                            echo $details_array['terms_conditions'];
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $details_array['company_data'][0]->terms_conditions;
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $details_array['company_data'][0]->terms_conditions;
                                                                    }
                                                                @endphp
                                                            </textarea>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    @if(isset($details_array['payment_terms_conditions_flag']) && $details_array['payment_terms_conditions_flag'] == 1)
                                                        <input type="checkbox" id="payment_terms_conditions_flag" name="payment_terms_conditions_flag" value="1" checked>&nbsp;&nbsp;&nbsp;<label> Payment Terms & condition</label>
                                                        <div id="pay_term">
                                                            <textarea class="summernote" id="payment_terms_conditions" name="payment_terms_conditions">
                                                                @php
                                                                    if(isset($details_array['payment_terms_conditions']))
                                                                    {
                                                                        if($details_array['payment_terms_conditions']!='')
                                                                        {
                                                                            echo $details_array['payment_terms_conditions'];
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $details_array['company_data'][0]->payment_terms_conditions;
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $details_array['company_data'][0]->payment_terms_conditions;
                                                                    }
                                                                @endphp
                                                            </textarea>
                                                        </div>
                                                    @else
                                                        <input type="checkbox" id="payment_terms_conditions_flag" name="payment_terms_conditions_flag" value="1">&nbsp;&nbsp;&nbsp;<label> Payment Terms & condition</label>
                                                        <div id="pay_term" style="display: none;">
                                                            <textarea class="summernote" id="payment_terms_conditions" name="payment_terms_conditions">
                                                                @php
                                                                    if(isset($details_array['payment_terms_conditions']))
                                                                    {
                                                                        if($details_array['payment_terms_conditions']!='')
                                                                        {
                                                                            echo $details_array['payment_terms_conditions'];
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $details_array['company_data'][0]->payment_terms_conditions;    
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $details_array['company_data'][0]->payment_terms_conditions;
                                                                    }
                                                                @endphp
                                                            </textarea>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    @if(isset($details_array['bank_details_flag']) && $details_array['bank_details_flag'] == 1)
                                                        <input type="checkbox" id="bank_details_flag" name="bank_details_flag" value="1" checked>&nbsp;&nbsp;&nbsp;<label>Bank Details</label>
                                                        <div id="bank">
                                                            <div id="company_bank">
                                                                <textarea class="summernote" id="bank_details" name="bank_details">
                                                                    @php
                                                                        if(isset($details_array['bank_details']) && $details_array['gst']==1)
                                                                        {
                                                                            if($details_array['bank_details']!='' && $details_array['gst']==1)
                                                                            {
                                                                                echo $details_array['bank_details'];
                                                                            }
                                                                            else
                                                                            {
                                                                                echo $details_array['company_data'][0]->bank_details;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $details_array['company_data'][0]->bank_details;
                                                                        }
                                                                    @endphp
                                                                </textarea>
                                                            </div>
                                                            <div id="private_bank" style="display: none;">
                                                                <textarea class="summernote" style="display: none;" id="personal_bank_details" name="personal_bank_details">
                                                                    @php
                                                                        if(isset($details_array['bank_details']) && $details_array['gst']==0)
                                                                        {
                                                                            if($details_array['bank_details']!='' && $details_array['gst']==0)
                                                                            {
                                                                                echo $details_array['bank_details'];
                                                                            }
                                                                            else
                                                                            {
                                                                                echo $details_array['company_data'][0]->personal_bank_details;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $details_array['company_data'][0]->personal_bank_details;
                                                                        }
                                                                    @endphp
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input type="checkbox" id="bank_details_flag" name="bank_details_flag" value="1">&nbsp;&nbsp;&nbsp;<label>Bank Details</label>
                                                        <div id="bank">
                                                            <div id="company_bank">
                                                                <textarea class="summernote" id="bank_details" name="bank_details">
                                                                    @php
                                                                        if(isset($details_array['bank_details']) && $details_array['gst']==1)
                                                                        {
                                                                            if($details_array['bank_details']!='' && isset($details_array['gst'])==1)
                                                                            {
                                                                                echo $details_array['bank_details'];
                                                                            }
                                                                            else
                                                                            {
                                                                                echo $details_array['company_data'][0]->bank_details;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $details_array['company_data'][0]->bank_details;
                                                                        }
                                                                    @endphp
                                                                </textarea>
                                                            </div>
                                                            <div id="private_bank" style="display: none;">
                                                                <textarea class="summernote" style="display: none;" id="personal_bank_details" name="personal_bank_details">
                                                                    @php
                                                                        if(isset($details_array['bank_details']) && $details_array['gst']==0)
                                                                        {
                                                                            if($details_array['bank_details']!='' && isset($details_array['gst'])==0)
                                                                            {
                                                                                echo $details_array['bank_details'];
                                                                            }
                                                                            else
                                                                            {
                                                                                echo $details_array['company_data'][0]->personal_bank_details;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $details_array['company_data'][0]->personal_bank_details;
                                                                        }
                                                                    @endphp
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="finalbtn" class="btn btn-primary">Submit</button>
                                    </form>
                                    <!-- <div class="modal" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog"> -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: #868e96;">
                                                    <h6 class="modal-title">Select Item</h6>
                                                    <button type="button" class="btn btn-danger close" data-dismiss="modal" style="background-color:red;">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <select id="item_id" name="item_id" class="form-control select2" required onchange="itemchange()">
                                                                        <option value="">Please Select Item</option>
                                                                        @foreach($details_array['item_data'] as $item)
                                                                            <option value="{{ $item->id }}" data-id="{{ $item->item_name }}" data-name="{{ strip_tags($item->description) }}">{{ $item->item_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <button type="button" id="add_item" name="add_item" class="btn btn-primary" data-dismiss="modal">Add</button>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <a href="{{ url('/item_master_add')}}" class="btn btn-primary">Add New Item</a>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    $('.item').click(function()
    {
        $('.item').each(function () {
            var id=$(this).val();
            if($(this).is(':checked'))
            {
                $("#item_price_"+id+"").prop('disabled',false);
                $("#item_desc_"+id+"").prop('disabled',false);
                $("#item_qty_"+id+"").prop('disabled',false);
                $("#item_qty_id_"+id+"").prop('disabled',false);
                // $("#item_price_"+id+"").prop('required',true);
                // $("#item_qty_"+id+"").prop('required',true);
                // $("#item_desc_"+id+"").prop('required',true);
                // $("#item_qty_id_"+id+"").prop('required',true);
            }
            else
            {
                $("#item_price_"+id+"").prop('disabled',true);
                $("#item_desc_"+id+"").prop('disabled',true);
                $("#item_qty_"+id+"").prop('disabled',true);
                $("#item_qty_id_"+id+"").prop('disabled',true);
                $("#item_price_"+id+"").prop('required',false);
                $("#item_desc_"+id+"").prop('required',false);
                $("#item_qty_"+id+"").prop('required',false);
                $("#item_qty_id_"+id+"").prop('required',false);
            }
        });

        calculate_amount();
    });

    function calculate_amount()
    {
        var gst_per=$("#gst_per").val();
        var discount=$("#discount").val();
        var total_amount=0;
        var amount=0;
        $('.item').each(function ()
        {
            if($(this).is(':checked'))
            {
                var id=$(this).val();
                var amt=$("#item_price_"+id+"").val();
                if(amt>=0 && amt!='')
                {
                    amount=parseInt(amount)+parseInt(amt);
                }
            }
        });

        if(parseFloat(discount)<0 || parseFloat(discount)>100 || discount=='')
        {
            $("#discount").val(0);
            discount=0;
        }

        var discount_amount=((parseFloat(amount)*parseFloat(discount))/100).toFixed(2);
        var dp_amount=(parseFloat(amount)-parseFloat(discount_amount)).toFixed(2);

        if(parseFloat(gst_per)>100)
        {
            $("#gst_per").val(100);
            gst_per=100;
        }
        else if(parseFloat(gst_per)<0)
        {
            $("#gst_per").val(0);
            gst_per=0;
        }
        else if(gst_per=='')
        {
            $("#gst_per").val(0);
            gst_per=0;   
        }

        var gst_amount=((parseFloat(dp_amount)*parseFloat(gst_per))/100).toFixed(2);
        total_amount=(parseFloat(dp_amount)+parseFloat(gst_amount)).toFixed(2);
        $("#total_amount").val(total_amount);
    }

    $("#finalbtn").click(function(e)
    {
        var flag=0;
        $('.item').each(function()
        {
            var id=$(this).val();
            if($(this).is(':checked'))
            {
                flag=1;
            }
        });

        if(flag!=1)
        {
            $(".item").prop('required', true);
            e.preventdefault();
            $("#erritem").show(0).delay(2500).hide(0);
        }
        else
        {
            $(".item").prop('required', false);
        }

    });

    $(".number").on('keypress keyup focusout', function()
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
        calculate_amount();
    });

    $(".number1").on('keyup', function()
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
        calculate_amount();
    });
    
    function number1(id)
    {
        var amt=$("#item_price_"+id+"").val();
        var value = amt.replace(/[^0-9\.]/g,'');
        $("#item_price_"+id+"").val(value);
        calculate_amount();
    }

    $("#gst").click(function()
    {
        gst_fun();
    });

    function gst_fun()
    {
        if($('#gst').is(':checked'))
        {
            $("#company_bank").css('display', 'block');
            $("#private_bank").css('display', 'none');
            $("#gst_div").css('display', 'block');
        }
        else
        {
            $("#company_bank").css('display', 'none');
            $("#private_bank").css('display', 'block');
            $("#gst_div").css('display', 'none');
            $("#igst").prop("checked", false);
            $("#gst_per").val(0);
        }
        calculate_amount();
    }

    $('#terms_conditions_flag').click(function()
    {
        var id=$(this).val();
        if($(this).is(':checked'))
        {
            $("#term").css('display','block');
        }
        else
        {
            $("#terms_conditions").prop('required',false);
            $("#term").css('display','none');
        }
    });

    $('#payment_terms_conditions_flag').click(function()
    {
        var id=$(this).val();
        if($(this).is(':checked'))
        {
            // $("#payment_terms_conditions").prop('required',true);
            $("#pay_term").css('display','block');
        }
        else
        {
            $("#payment_terms_conditions").prop('required',false);
            $("#pay_term").css('display','none');
        }
    });

    $('#bank_details_flag').click(function()
    {
        var id=$(this).val();
        if($(this).is(':checked'))
        {
            $("#bank").css('display','block');
        }
        else
        {
            $("#bank_details").prop('required',false);
        }

        gst_fun();
    });
</script>
<script>
    $("#add_item").click(function ()
    {
        var id=$("#item_id").val();
        if(id!='')
        {
            itembox(id);
            $("#add_item").css('display', 'none');

        }   
    });

    function itemchange()
    {
        var id=$("#item_id").val();
        if(id!='')
        {
            $("#add_item").css('display', 'block');
        }
    }

    function removefun(id)
    {
        $('#item_id option[value="'+id+'"]').attr("disabled", false);
        $("#"+id+"").text('');
        $("#"+id+"").remove();
    }

    function itembox(id)
    {
        var symbol="{{ $currency_data->symbol }}";
        var name=$("#item_id").find(":selected").text();
        var description=$("#item_id").find(":selected").data('name');
        var field='<div class="row form-group" id="'+id+'"><div class="col-md-1"><label for="name"><b>'+name+'</b></label></div><div class="col-md-5"><input type="checkbox" class="item" id="item[]" name="item[]" value="'+id+'" checked hidden> <textarea required type="textarea" class="summernote" placeholder="'+name+' Description" id="item_desc_'+id+'" name="item_desc_'+id+'" rows="5" cols="40">'+description+'</textarea></div><div class="col-md-2"><input type="number" required class="form-control number" id="item_qty_'+id+'" value="1" name="item_qty_'+id+'" placeholder="Qty"></div><div class="col-md-2"><input required type="text" class="form-control number1" onkeyup="number1('+id+')" id="item_price_'+id+'" name="item_price_'+id+'" placeholder="Price ('+symbol+')" value=""></div><div class="col-md-1"><button type="button" class="btn btn-danger" id="btn_'+id+'" onclick="removefun('+id+')" name="btn_'+id+'" >Remove</button></div></div>';

        $("#items").after(field).load();
        $("#item_id").find(":selected").attr("disabled","disabled");
        $('.summernote').summernote();
    }
</script>
@if(isset($details_array['igst']))
    <script>
        $( document ).ready(function()
        {
            var igst="{{ $details_array['igst'] }}";
            if(igst == 1)
            {
                $("#igst").prop("checked", true);
            }

            $('.item').each(function ()
            {
                var id=$(this).val();
                $("#item_id option[value="+id+"]").prop('disabled', true);
            });
        });
    </script>
@endif

@if(isset($details_array['gst']))
    <script>
        $( document ).ready(function()
        {
            var gst="{{ $details_array['gst'] }}";
            if(gst == 1)
            {
                $("#gst").prop("checked", true);
                gst_fun();
            }
        });
    </script>
@endif

@if(!isset($details_array['quotation_id']))
    <script>
        $( document ).ready(function()
        {
            $('.item').each(function ()
            {
                var id=$(this).val();
                $("#item_price_"+id+"").prop('disabled',true);
                $("#item_desc_"+id+"").prop('disabled',true);
                $("#item_qty_"+id+"").prop('disabled',true);
            });
        });
    </script>
@endif
<script>
    $( document ).ready(function()
    {
        $('#item_id').select2({
            dropdownParent: $('#myModal'),
            width:'100%'
        });

        $('.select2-container').css('display', 'inline-table');
        $('.modal-footer').css('padding', '5px');

        $('.tox-notifications-container').css('display', 'none !important');

        $('.summernote').summernote();
        gst_fun();
    });
</script>
@endsection
