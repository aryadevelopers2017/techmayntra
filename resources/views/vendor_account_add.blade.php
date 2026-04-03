@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 col-md-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>{{ isset($data->id) ? 'Edit' : 'Add New' }} Vendor Account</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ isset($data->id) ? 'Edit' : 'Add' }} Vendor Account</li>
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
                                    <form action="{{ url('/update_vendor_account') }}" id="vendoraccountform" method="POST">
                                        <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
                                        @else
                                        <form action="{{ url('/add_vendor_account') }}" id="vendoraccountform" method="POST">
                                            @endif

                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" id="is_edit" value="{{ isset($data->id) ? 1 : 0 }}">
                                            <div class="row">
                                                {{-- LEFT COLUMN --}}
                                                <div class="col-md-6">
                                                    {{-- Date --}}
                                                    <div class="form-group">
                                                        <label>Purchase Date <span class="text-danger">*</span></label>
                                                        @if(isset($data->date))
                                                        <input type="date"
                                                            class="form-control"
                                                            id="date"
                                                            name="date"
                                                            max="{{ date('Y-m-d', strtotime($data->date)) }}"
                                                            min="{{ date('Y-m-01', strtotime($data->date)) }}"
                                                            value="{{ $data->date }}"
                                                            required>
                                                        @else
                                                        <input type="date"
                                                            class="form-control"
                                                            id="date"
                                                            name="date"
                                                            max="{{ date('Y-m-d') }}"
                                                            min="{{ date('Y-m-01') }}"
                                                            value="{{ date('Y-m-d') }}"
                                                            required>
                                                        @endif
                                                        <span id="errdate" style="display:none; color:#ff0000;">Please Select Purchase Date</span>
                                                    </div>



                                                    {{-- Company Name --}}
                                                    <div class="form-group">
                                                        <label>Company Name <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control"
                                                            id="company_name"
                                                            name="company_name"
                                                            placeholder="Enter Company Name"
                                                            value="{{ isset($data->company_name) ? $data->company_name : '' }}"
                                                            required>
                                                        <span id="errcompany_name" style="display:none; color:#ff0000;">Please Enter Company Name</span>
                                                    </div>

                                                    {{-- Description --}}
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control height-150"
                                                            id="description"
                                                            name="description"
                                                            rows="5">{{ isset($data->description) ? $data->description : '' }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="0" {{ isset($data->status) && $data->status == 0 ? 'selected' : '' }}>Pending</option>
                                                            <option value="1" {{ isset($data->status) && $data->status == 1 ? 'selected' : '' }}>Paid</option>
                                                        </select>
                                                    </div>


                                                </div>

                                                {{-- RIGHT COLUMN --}}
                                                <div class="col-md-6">

                                                    {{-- Vendor Name --}}
                                                    <div class="form-group">
                                                        <label>Vendor Name <span class="text-danger">*</span></label>
                                                        <select name="vendor_id" id="vendor_id" class="form-control select2" required onchange="get_vendor_details();">
                                                            <option value="" selected disabled>Please Select Vendor</option>
                                                            @foreach($vendor_list as $vendordata)
                                                            <option value="{{ $vendordata->id }}"
                                                                {{ isset($data->vendor_id) && $data->vendor_id == $vendordata->id ? 'selected' : '' }}>
                                                                {{ $vendordata->name }} - {{ $vendordata->company_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span id="errvendor_name" style="display:none; color:#ff0000;">Please Select Vendor Name</span>
                                                    </div>

                                                    {{-- Address --}}
                                                    <div class="form-group">
                                                        <label>Address <span class="text-danger">*</span></label>
                                                        <textarea class="form-control"
                                                            id="address"
                                                            name="address"
                                                            rows="5"
                                                            cols="100"
                                                            required>{{ isset($data->address) ? $data->address : '' }}</textarea>
                                                        <span id="erraddress" style="display:none; color:#ff0000;">Please Enter Address</span>
                                                    </div>

                                                    {{-- Country --}}
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select name="country_id" id="country" class="form-control select2" onchange="getStateByCountry();">
                                                            <option value="" selected>Please Select Country</option>
                                                            @foreach($country_data as $country)
                                                            @php
                                                            $selected = '';
                                                            if (isset($data->country_id) && $data->country_id == $country->id) {
                                                            $selected = 'selected';
                                                            }
                                                            @endphp
                                                            <option value="{{ $country->id }}" {{ $selected }}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- State --}}
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select name="state_id" id="state" onchange="getcity();" class="form-control select2">
                                                            <option value="" selected>Please Select State</option>
                                                            @foreach($state_data as $state)
                                                            @php
                                                            $selected = '';
                                                            if (isset($data->state_id) && $data->state_id == $state->id) {
                                                            $selected = 'selected';
                                                            }
                                                            @endphp
                                                            <option value="{{ $state->id }}" {{ $selected }}>{{ $state->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="errstate" style="display:none; color:#ff0000;">Please Select State</span>
                                                    </div>

                                                    {{-- City --}}
                                                    <div class="form-group" style="margin-top: 30px;">
                                                        <label>City</label>
                                                        <select id="city" name="city_id" class="form-control select2">
                                                            <option value="{{ isset($data->city_id) ? $data->city_id : '' }}" selected>
                                                                {{ isset($data->city_id) ? $data->city_id : 'Please Select City' }}
                                                            </option>
                                                            @if(isset($city_data) && count($city_data) > 0)
                                                            @foreach($city_data as $city)
                                                            @php
                                                            $selected = '';
                                                            if (isset($data->city_id) && $data->city_id == $city->id) {
                                                            $selected = 'selected';
                                                            }
                                                            @endphp
                                                            <option value="{{ $city->id }}" {{ $selected }}>{{ $city->name }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <span id="errcity" style="display:none; color:#ff0000;">Please Select City</span>
                                                    </div>

                                                </div>
                                            </div>



                                            {{-- TOTAL AMOUNT --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">

                                                        <!--  Show pending -->
                                                        <small id="pending_amount_text" style="color: green; display:block; margin-bottom:5px;"></small>

                                                        <label>Total Amount</label>
                                                        <input type="text"

                                                            class="form-control number"
                                                            id="total_amount"
                                                            name="total_amount"
                                                            placeholder="0"
                                                            value="{{ isset($data->total_amount) ? $data->total_amount : '0' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- PAYMENT MODE --}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Payment Mode</label>
                                                        <div style="margin-left: 10px;">
                                                            <label>
                                                                <input type="radio" name="payment_mode" class="payment_mode" value="cash">
                                                                &nbsp;&nbsp;&nbsp; Cash &nbsp;&nbsp;&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="payment_mode" class="payment_mode" value="Net Banking">
                                                                &nbsp;&nbsp;&nbsp; Bank Transfer &nbsp;&nbsp;&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="payment_mode" class="payment_mode" value="Mobile Application">
                                                                &nbsp;&nbsp;&nbsp; Credit Card Payment &nbsp;&nbsp;&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="payment_mode" class="payment_mode" value="Tabby">
                                                                &nbsp;&nbsp;&nbsp; Tabby &nbsp;&nbsp;&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="payment_mode" class="payment_mode" value="Tamara">
                                                                &nbsp;&nbsp;&nbsp; Tamara &nbsp;&nbsp;&nbsp;
                                                            </label>
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
    var max_pending_amount = 0;

    $(document).ready(function() {
        $('.select2-container').css('display', 'inline-table');
        $('.tox-notifications-container').css('display', 'none !important');
    });


    $(document).ready(function() {
        let edit_vendor_id = $("#vendor_id").val();

        if (edit_vendor_id) {
            get_vendor_details();
        }
    });
    // ─── City / State / Country ───────────────────────────────────────────────

    function getcity(selected_city_id = null) {
        var state_id = $("#state").val();
        $("#city").html('');

        $.ajax({
            type: 'POST',
            url: "{{ url('/getCityBystateId') }}",
            data: {
                'state_id': state_id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.city.status_code == 200) {
                    var option = '<option value="" disabled>Please Select City</option>';

                    $.each(data.city.data, function(index, value) {
                        option += '<option value="' + value.id + '">' + value.name + '</option>';
                    });

                    $("#city").html(option);

                    // ✅ Set selected city AFTER options loaded
                    if (selected_city_id) {
                        $("#city").val(selected_city_id).trigger('change');
                    }
                }
            }
        });
    }

    function getStateByCountry() {
        var country_id = $("#country").val();
        $("#state").html('');

        $.ajax({
            type: 'POST',
            url: "{{ url('/getStateBycountryId') }}",
            data: {
                'country_id': country_id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.state.status_code == 200) {
                    var option = '<option value="" selected disabled>Please Select State</option>';
                    $.each(data.state.data, function(index, value) {
                        option += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $("#state").html(option);
                }
            }
        });
    }

    // ─── Vendor Details Auto-fill ─────────────────────────────────────────────

    function get_vendor_details() {
        let vendor_id = $("#vendor_id").val();
        if (!vendor_id) return;

        $.ajax({
            url: "{{ route('get.vendor.details') }}",
            type: "GET",
            data: {
                vendor_id: vendor_id
            },
            success: function(response) {

                $("#company_name").val(response.company_name);
                $("#address").val(response.address);

                // Show pending amount text
                let pending = Number(response.pending_amount);
                if (isNaN(pending)) pending = 0;

                max_pending_amount = pending;

                // ALWAYS update UI (NO IF CONDITION)
                $("#pending_amount_text").text("Pending Amount :- " + pending);

                // edit mode check
                let is_edit = $("#is_edit").val();

                if (is_edit == "0") {
                    $("#total_amount").val(pending);
                }
                // Set country
                $("#country").val(response.country_id).trigger("change");

                // Load states
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/getStateBycountryId') }}",
                    data: {
                        'country_id': response.country_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.state.status_code == 200) {

                            let option = '<option value="">Please Select State</option>';
                            $.each(data.state.data, function(index, value) {
                                option += `<option value="${value.id}">${value.name}</option>`;
                            });

                            $("#state").html(option);

                            // Set state
                            $("#state").val(response.state_id).trigger("change");

                            //  Now load city with selected city_id
                            getcity(response.city_id);
                        }
                    }
                });
            }
        });
    }


    $(".number").on('keypress keyup focusout', function() {

        // Clean input
        this.value = this.value.replace(/[^0-9\.]/g, '')
            .replace(/^(\d*\.?\d*)\..*$/, '$1');

        let value = parseFloat($(this).val()) || 0;

        if (value > max_pending_amount) {
            alert("Amount cannot be greater than pending amount :- " + max_pending_amount);

            $(this).val(max_pending_amount);
            value = max_pending_amount;
        }

    });
</script>


{{-- Restore status on edit --}}
@if(isset($data->status))
<script>
    $(document).ready(function() {
        var my_status = "{{ $data->status }}";
        $(".status").each(function() {
            if ($(this).val() == my_status) {
                $(this).prop('checked', true);
            }
        });
    });
</script>
@endif

{{-- Restore payment mode on edit --}}
@if(isset($data->payment_mode))
<script>
    $(document).ready(function() {
        var payment_mode = "{{ $data->payment_mode }}";
        $(".payment_mode").each(function() {
            if ($(this).val() == payment_mode) {
                $(this).prop('checked', true);
            }
        });
    });
</script>
@endif


@endsection
