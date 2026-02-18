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
                <div class="col-lg-7 col-md-6  p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Invoice </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Invoice</li>
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
                                        <form action="{{ url('/update_invoice') }}" id="quotationform" method="POST">
                                            <input type="hidden" name="id" id="id" value="{{ $details_array['quotation_id'] }}" />
                                    @else
                                        <form action="{{ url('/save_invoice') }}" id="quotationform" method="POST">
                                    @endif
                                    <input type="hidden" name="services_item" id="services_item">

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
                                                    <label>Select Client </label>
                                                    <select id="c_id" name="c_id" class="form-control select2" required>
                                                        <option value="">Please Select Client</option>
                                                        @foreach($details_array['customer_data'] as $customer)
                                                            @if(isset($details_array['customer_id']) && $details_array['customer_id'] == $customer->id)
                                                                <option value="{{ $customer->id }}" selected>{{ $customer->name }} - {{ $customer->company_name }}</option>
                                                            @else
                                                                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->company_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span id="errname" style="display:none;color: #ff0000;">Please Select Client</span>
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
                                            <div class="form-group col-lg-12">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Service</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Service</label>
                                                 <div class="form-group" id="items"></div>
                                            </div>
                                        </div>



                                            @if(isset($details_array['quotation_id']))
                                            @php $rowCounter = 0; @endphp

                                            @foreach($details_array['item_data'] as $item)
                                            @if($item->price > 0)

                                            @php $rowCounter++; @endphp

                                            <div class="row form-group item-row"
                                                data-row-id="{{ $rowCounter }}"
                                                data-item-id="{{ $item->item_id }}">

                                                <!-- LEFT PART -->
                                                <div class="col-md-6">
                                                    <h4><b>{{ $item->item_name }}</b></h4>

                                                    <textarea class="item-desc summernote"
                                                            placeholder="{{ $item->item_name }} Description"
                                                            rows="5">{{ $item->description }}</textarea>
                                                </div>

                                                <!-- RIGHT PART -->
                                                <div class="col-md-6">

                                                    <!-- CHILD ROW 1 -->
                                                    <div class="row mb-2">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label><b>Qty</b></label> &nbsp;&nbsp;
                                                            <input type="number"
                                                                class="form-control item-qty"
                                                                value="{{ $item->qty }}"
                                                                min="1"
                                                                required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label><b>Action</b></label>
                                                            <button type="button"
                                                                class="btn btn-primary remove-item w-100">
                                                                Remove
                                                            </button>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label><b>Enter Price</b></label>
                                                            <input type="number"
                                                                class="form-control item-orignal-price"
                                                                value="{{ $item->original_price ?? '' }}"
                                                                placeholder="Price ({{ $currency_data->symbol }})"
                                                                required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label><b>Admin Cost</b></label>
                                                            <input type="text"
                                                                class="form-control item-admin-cost-price"
                                                                value="{{ $item->admin_cost ?? '' }}"
                                                                placeholder="Admin Cost"
                                                                readonly
                                                                required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label><b>Tax ({{ $item->taxtype ? $item->taxtype : 'GST'}})</b></label>
                                                            <input type="hidden" value="{{ $item->taxtype ? $item->taxtype : 'GST'}}" class="item-tax-type">
                                                            <input
                                                                type="number"
                                                                class="form-control item-tax-percent"
                                                                placeholder="Tax %"
                                                                value="{{ $item->taxvalue }}"
                                                                min="0"
                                                                max="100"
                                                            >
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label><b>Final Price</b></label>
                                                            <input type="text"
                                                                class="form-control item-price"
                                                                value="{{ $item->price }}"
                                                                placeholder="Final Price ({{ $currency_data->symbol }})"
                                                                readonly
                                                                required>
                                                        </div>

                                                    </div>
                                                    <!-- CHILD ROW 2 -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label><b>Passenger Type</b></label><br>

                                                            <label>
                                                                <input type="radio"
                                                                    name="passenger_{{ $rowCounter }}"
                                                                    value="adult"
                                                                    {{ $item->passenger_type == 'adult' ? 'checked' : '' }}>
                                                                Adult
                                                            </label>

                                                            &nbsp;&nbsp;

                                                            <label>
                                                                <input type="radio"
                                                                    name="passenger_{{ $rowCounter }}"
                                                                    value="child"
                                                                    {{ $item->passenger_type == 'child' ? 'checked' : '' }}>
                                                                Child
                                                            </label>
                                                        </div>

                                                        <div class="col-md-6 " style="display: none;" >
                                                            <label><b>Ticket Type</b></label>

                                                            <select class="form-control service-type">
                                                                <option value="">Select Ticket Type</option>
                                                                @php
                                                                $category = collect($details_array['service_types'])
                                                                    ->firstWhere('id', $item->category_id);
                                                            @endphp

                                                            @if($category)
                                                                @foreach($category['services'] as $service)
                                                                    <option value="{{ $service['code'] }}"
                                                                        {{ $item->service_type == $service['code'] ? 'selected' : '' }}>
                                                                        {{ $service['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            @endif
                                            @endforeach
                                            @endif

                                        <span id="erritem" style="display: none; color: #ff0000;">Please Select item</span>

                                         <div class="col-lg-6" style="display: none;">
                                                <div class="form-group row mt-4">
                                                    <div class="col-md-3">
                                                        <input type="checkbox" id="gst"  name="gst" value="1">&nbsp;&nbsp;&nbsp;<label>GST</label>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="checkbox" id="vat" name="vat" value="1">
                                                        &nbsp;&nbsp;&nbsp;<label>VAT</label>
                                                    </div>
                                                </div>

                                                <div id="gst_div" style="display: none;margin-left: -7px !important;">
                                                    <div class="form-group" id="igst_div">
                                                        <div class="col-md-3 mt-5">
                                                            <input type="checkbox" id="igst" name="igst" value="1">&nbsp;&nbsp;&nbsp;<label>IGST</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label id="tax_label">GST (%)</label>
                                                        <input type="text" class="form-control number" id="gst_per" value="{{ isset($details_array['gst_per']) ? $details_array['gst_per'] : 18 }}" max="100" min="0" name="gst_per" placeholder="GST (%)" required>

                                                    </div>
                                                </div>
                                        </div>
                                             <div class="row col-12">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Discount (%)</label>
                                                    <input type="text" class="form-control number" id="discount" value="{{ isset($details_array['discount']) ? $details_array['discount'] : '' }}" min="0" max="100" name="discount" placeholder="0" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label>Total Amount ({{ $currency_data->symbol }})</label>
                                                    <input type="text" class="form-control number" id="total_amount" name="total_amount" readonly disabled value="{{ isset($details_array['total_amount']) ? $details_array['total_amount'] : '0'}}" required>
                                                </div>

                                            </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> {{ $details_array['company_data'][0]->technology_label ?? 'Technology' }}  </label>
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
                                                    <label> {{ $details_array['company_data'][0]->milestone_label ?? 'Mile Stone' }}  </label>
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
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Select Service</h6>
                                                    <button type="button" class="btn btn-danger close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <select id="item_id" name="item_id" class="form-control select2" required >
                                                                        <option value="">Please Select Service</option>
                                                                        @foreach($details_array['item_data'] as $item)
                                                                            <option value="{{ $item->id }}" data-id="{{ $item->item_name }}"

                                                                             data-category-id="{{ $item->category_id }}"

                                                                             data-admin-cost="{{ $item->admin_cost }}"


                                                                             data-tax-type="{{ $item->tax_type }}"


                                                                             data-tax-value="{{ $item->tax_value }}"

                                                                            data-name="{{ strip_tags($item->description) }}">{{ $item->item_name }}</option>
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


    const SERVICE_TYPES = @json($details_array['service_types']);

$(document).on("input", ".item-orignal-price, .item-tax-percent, .item-qty", function () {

    let row = $(this).closest(".item-row");

    let originalPrice = parseFloat(row.find(".item-orignal-price").val()) || 0;
    let adminCost = parseFloat(row.find(".item-admin-cost-price").val()) || 0;
    let taxPercent = parseFloat(row.find(".item-tax-percent").val()) || 0;
    let qty = parseFloat(row.find(".item-qty").val()) || 1;

    if (taxPercent < 0) taxPercent = 0;
    if (taxPercent > 100) taxPercent = 100;

    if (qty < 1) qty = 1;

    let basePrice = originalPrice + adminCost;

    let taxAmount = (basePrice * taxPercent) / 100;

    let subTotal = basePrice + taxAmount;     // without qty
    let finalPrice = subTotal * qty;          // with qty

    // set subtotal
    row.find(".item-sub-total").val(subTotal.toFixed(2));

    // set final price
    row.find(".item-price").val(finalPrice.toFixed(2));

});





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


    // Whenever quantity or price changes
     $(document).on("input", ".item-qty, .item-orignal-price, .item-tax-percent", calculate_amount);


    // Whenever discount or GST changes
    $("#discount, #gst_per").on("input", calculate_amount);

    function calculate_amount() {
        let total = 0;
        let discount = parseFloat($("#discount").val()) || 0;
        let gst_per = parseFloat($("#gst_per").val()) || 0;

        // Loop through all items
        $(".item-row").each(function() {
            // const qty = parseFloat($(this).find(".item-qty").val()) || 0;
            const price = parseFloat($(this).find(".item-price").val()) || 0;
            total += price;
        });

        // Validate discount
        if (discount < 0 || discount > 100) {
            discount = 0;
            $("#discount").val(0);
        }

        // Apply discount
        const discountAmount = total * discount / 100;
        const amountAfterDiscount = total - discountAmount;

        // Validate GST
        // if (gst_per <
        // (gst_per);

        // Apply GST
        // const gstAmount = amountAfterDiscount * gst_per / 100;

        // Final total
        const totalAmount = amountAfterDiscount ;

        $("#total_amount").val(totalAmount.toFixed(2));
    }


   $("#finalbtn").click(function (e) {
    e.preventDefault(); // stop default submit

    const itemsData = [];

    // Collect all service rows
    $(".item-row").each(function () {
        const itemId = $(this).data("item-id");
        const description = $(this).find(".item-desc").val();
        const qty = parseFloat($(this).find(".item-qty").val()) || 0;
        const price = parseFloat($(this).find(".item-price").val()) || 0;

        const original_Price = parseFloat($(this).find(".item-orignal-price").val()) || 0;

        const passengerType = $(this).find("input[type=radio]:checked").val();
        const serviceType = $(this).find(".service-type").val();


        const taxtype = parseFloat($(this).find(".item-tax-type").val()) || 'GST';
        const taxvalue = parseFloat($(this).find(".item-tax-percent").val()) || 0;



        if (qty > 0 && price > 0) {
            itemsData.push({
                item_id: itemId,
                description: description,
                qty: qty,
                price: price ,
                passenger_type: passengerType,
                service_type: serviceType,
                original_price: original_Price,
                taxtype: taxtype,
                taxvalue: taxvalue
            });
        }
    });

    //  No service added
    if (itemsData.length === 0) {
        $("#erritem").show().delay(2500).hide();
        return;
    }

    // Assign JSON to hidden input
    $("#services_item").val(JSON.stringify(itemsData));

    // Recalculate total one last time
    calculate_amount();

    // Submit the form
    $("#quotationform").submit();
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


    $("#gst").on('change', gst_fun);
$("#vat").on('change', vat_fun);


    function gst_fun()
{
    if ($('#gst').is(':checked'))
    {
        $("#vat").prop("checked", false);

        $("#company_bank").show();
        $("#private_bank").hide();

        $("#gst_div").show();
        $("#tax_label").text('GST (%)');
    }
    else
    {
        $("#company_bank").hide();
        $("#private_bank").show();
        $("#igst").prop("checked", false);

        // Hide ONLY if VAT is not checked
        if (!$('#vat').is(':checked')) {
            $("#gst_div").hide();
            $("#gst_per").val(0);
        }
    }

    calculate_amount();
}


    function vat_fun()
{
    if ($('#vat').is(':checked'))
    {
        $("#gst").prop("checked", false);
        $("#igst").prop("checked", false);

        $("#gst_div").show();
        $("#tax_label").text('VAT (%)');
    }
    else
    {
        // Hide ONLY if GST is not checked
        if (!$('#gst').is(':checked')) {
            $("#gst_div").hide();
            $("#gst_per").val(0);
        }
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

<!-- -------  add services -------- -->
<script>

let rowCounter = 0;

// Add Item Button
$("#add_item").on("click", function() {
    const itemId = $("#item_id").val();
    if (!itemId) return;

    rowCounter++;
    addItemRow(itemId, rowCounter);
});


function addItemRow(itemId, rowId) {
    const symbol = "{{ $currency_data->symbol }}";
    const name = $("#item_id option:selected").text();
    const description = $("#item_id option:selected").data("name");
    const categoryId = $("#item_id option:selected").data("category-id");

    const add_item_admin_cost = $("#item_id option:selected").data("admin-cost");

    const add_item_tax_type = $("#item_id option:selected").data("tax-type");
    const add_item_tax_value = $("#item_id option:selected").data("tax-value");



    const row = `
    <div class="row form-group item-row" data-row-id="${rowId}" data-item-id="${itemId}">

        <!-- LEFT PART -->
        <div class="col-md-6">
            <h4><b>${name}</b></h4>
            <textarea
                class="item-desc summernote"
                placeholder="${name} Description"
                rows="5"
                required
            >${description}</textarea>
        </div>

        <!-- RIGHT PART -->
        <div class="col-md-6">

            <!-- CHILD ROW 1 -->
            <div class="row mb-2">


                <div class="col-md-6">
                    <label><b>Passenger Type</b></label><br>
                    <label>
                        <input type="radio" name="passenger_${rowId}" value="adult" checked>
                        Adult
                    </label>
                    &nbsp;&nbsp;
                    <label>
                        <input type="radio" name="passenger_${rowId}" value="child">
                        Child
                    </label>
                </div>


                <div class="col-md-6 ">

                    <button type="button" class="btn btn-primary remove-item w-100">
                        Remove
                    </button>
                </div>

                <div class="col-md-4">
                    <label><b>Enter Price</b></label>
                    <input
                        type="number"
                        class="form-control item-orignal-price"
                        placeholder="Price (${symbol})"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label><b>Admin Cost</b></label>
                    <input
                        type="text"
                        class="form-control item-admin-cost-price"
                        placeholder="Admin Cost"
                        value="${add_item_admin_cost}"
                        required
                        readonly
                    >
                </div>

                <div class="col-md-4">
                    <label><b>Tax (${add_item_tax_type ? add_item_tax_type : 'GST'})</b></label>
                    <input type="hidden" value="${add_item_tax_type ? add_item_tax_type : 'GST'}" class="item-tax-type">
                    <input
                        type="number"
                        class="form-control item-tax-percent"
                        placeholder="Tax %"
                        value="${add_item_tax_value ? add_item_tax_value : 0}"
                        min="0"
                        max="100"
                    >
                </div>
              <div class="col-md-4">
                 <label><b>Qty</b></label> &nbsp;&nbsp;
                    <input
                        type="number"
                        class="form-control item-qty"
                        value="1"
                        min="1"
                        placeholder="Qty"
                        required
                    >
                </div>


                <div class="col-md-4">
                    <label><b>Sub Total</b></label>
                    <input
                        type="text"
                        class="form-control item-sub-total"
                        placeholder="Sub Total (${symbol})"
                        required
                        readonly
                    >
                </div>

                <div class="col-md-4">
                    <label><b>Final Price</b></label>
                    <input
                        type="text"
                        class="form-control item-price"
                        placeholder="Final Price (${symbol})"
                        required
                        readonly
                    >
                </div>



            </div>

            <!-- CHILD ROW 2 -->
            <div class="row">


                <div class="col-md-6" style="display: none;">
                    <label><b>Ticket Type</b></label>
                    <select class="form-control service-type">
                        <option value="">Select Ticket Type</option>
                       ${getServiceOptionsByCategory(categoryId)}
                    </select>

                </div>
            </div>

        </div>
    </div>
    `;

    $("#items").after(row);
    $('.summernote').summernote();
}


function getServiceOptionsByCategory(categoryId) {
    const category = SERVICE_TYPES.find(c => c.id == categoryId);

    if (!category) {
        return `<option value="">No Services Available</option>`;
    }

    return category.services.map(service =>
        `<option value="${service.code}">${service.name}</option>`
    ).join('');
}



// Remove Item (Event Delegation)
$(document).on("click", ".remove-item", function() {
    $(this).closest(".item-row").remove();

    calculate_amount();
});
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

@if(isset($details_array['vat']))
<script>
$(document).ready(function () {
    if ("{{ $details_array['vat'] }}" == 1) {
        $("#vat").prop("checked", true);
        vat_fun();
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

    $(document).ready(function () {
         if ($('#gst').is(':checked')) {
        gst_fun();
    }
    if ($('#vat').is(':checked')) {
        vat_fun();
    }



    //    console.log('Document ready fired');
        $('#item_id').select2({
            dropdownParent: $('#myModal'),
            width:'100%'
        });

        $('.select2-container').css('display', 'inline-table');
        $('.select2-container').css('width', '100%');
        $('.modal-footer').css('padding', '5px');

        $('.tox-notifications-container').css('display', 'none !important');

        // $('.summernote').summernote();

         try {
            // console.log('Initializing Summernote');
            $('.summernote').summernote();
        } catch (e) {
            console.error('Summernote error:', e);
        }

        gst_fun();
    });
</script>
@endsection
