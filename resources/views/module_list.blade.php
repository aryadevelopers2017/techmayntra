@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Company </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Company</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.Admin.messages')
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{ url('/update_module') }}" id="moduleform" method="POST" enctype="multipart/form-data">
                                        @if(isset($module_data[0]->id))
                                            <input type="hidden" name="id" id="id" value="{{ $module_data[0]->id }}" />
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="form-group">
                                            <label>Company Name </label>
                                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Title" value="{{ isset($module_data[0]->company_name) ? $module_data[0]->company_name : ''}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Default Currency </label>
                                            <select class="select2 form-control" required id="currency_id" name="currency_id">
                                                <option value="" disabled selected>Please Select Default Currency</option>
                                                @foreach($currency as $curr)
                                                    @if($curr->id == $module_data[0]->currency_id)
                                                        <option selected value="{{ $curr->id }}">{{ $curr->country_name }} {{ $curr->code }} {{ $curr->symbol }} </option>
                                                    @else
                                                        <option value="{{ $curr->id }}">{{ $curr->country_name }} {{ $curr->code }} {{ $curr->symbol }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Company Logo </label>
                                            <input type="file" class="form-control" id="company_logo" name="company_logo" alt="">
                                        </div>
                                        <div class="form-group">
                                            <label>Company Signature </label>
                                            <input type="file" class="form-control" id="company_sign" name="company_sign" alt="">
                                        </div>
                                        <div class="form-group">
                                            <label>Company Mobile </label>
                                            <input type="text" class="form-control number" id="company_mobile" name="company_mobile" value="{{ isset($module_data[0]->mobile) ? $module_data[0]->mobile : ''}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Company Email-ID </label>
                                            <input type="email" class="form-control" id="company_email" name="company_email" value="{{ isset($module_data[0]->email) ? $module_data[0]->email : ''}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Address </label>
                                            <br>
                                            <textarea id="address" name="address" rows="5" cols="40" style="width: 100%;border-color:#e7e7e7;">{{ isset($module_data[0]->address) ? $module_data[0]->address : '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>City </label>
                                            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{ isset($module_data[0]->city) ? $module_data[0]->city : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label>State </label>
                                            <input type="text" class="form-control" id="state" name="state" placeholder="State" value="{{ isset($module_data[0]->state) ? $module_data[0]->state : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Pan No </label>
                                            <input type="text" class="form-control" id="pan_no" name="pan_no" placeholder="Pan No" value="{{ isset($module_data[0]->pan_no) ?$module_data[0]->pan_no : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label>GST No </label>
                                            <input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="GST No" value="{{ isset($module_data[0]->gst_no) ? $module_data[0]->gst_no : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label>VAT No </label>
                                            <input type="text" class="form-control" id="vat_no" name="vat_no" placeholder="VAT No" value="{{ isset($module_data[0]->vat_no) ? $module_data[0]->vat_no : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="editable-label" id="lbl_technology" data-field="technology">{{ $module_data[0]->technology_label ?? 'Technology' }}</label>
                                            <label class="edit-icon" data-target="lbl_technology">
                                                <i class="fa fa-pencil"></i>
                                            </label>
                                            <textarea class="summernote" id="technology" name="technology">{{ $module_data[0]->technology ?? '' }}</textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="editable-label" id="lbl_milestone" data-field="milestone">{{ $module_data[0]->milestone_label ?? 'Mile Stone' }}</label>
                                            <label class="edit-icon" data-target="lbl_milestone">
                                                <i class="fa fa-pencil"></i>
                                            </label>
                                            <textarea class="summernote" id="milestone" name="milestone">{{ $module_data[0]->milestone ?? '' }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Term & Condition </label> 
                                            <textarea class="summernote" id="terms_conditions" name="terms_conditions">{{ isset($module_data[0]->terms_conditions) ? $module_data[0]->terms_conditions : '' }} </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Payment Term & Condition </label>
                                            <textarea class="summernote" id="payment_terms_conditions" name="payment_terms_conditions">{{ isset($module_data[0]->payment_terms_conditions) ? $module_data[0]->terms_conditions : '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Details </label>
                                            <textarea class="summernote" id="bank_details" name="bank_details">{{ isset($module_data[0]->bank_details) ? $module_data[0]->bank_details : '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Personal Bank Details </label>
                                            <textarea class="summernote" id="personal_bank_details" name="personal_bank_details">{{ isset($module_data[0]->personal_bank_details) ? $module_data[0]->personal_bank_details : '' }}</textarea>
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
        $('.summernote').summernote(); 
    });
	
	$(document).on("click", ".edit-icon", function () {
		let target = $(this).data("target");
		$("#" + target).trigger("click");
	});
	
	$(document).on("click", ".editable-label", function () {
		let label = $(this);
		let currentText = label.text().trim();
		let id = label.attr("id");
		let field = label.data("field");
	
		let input = $('<input>', {
			type: "text",
			class: "label-editor",
			id: field+"_label",
			name: field+"_label",
			value: currentText
		});
	
		label.replaceWith(input);
		input.focus();
	});
	
</script>
@endsection
