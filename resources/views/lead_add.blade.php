@extends('layouts.Admin.app')

@section('content')

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Lead </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Lead Master</li>
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
                                        $lead_data=$data;
                                        $client_lists=$data['client_lists'];
                                        $state=$data['state_data'];
                                    @endphp
                                    @if(isset($lead_data->id))
                                        <form action="{{ url('/update_lead') }}" id="leadformsubmit" method="POST">
                                            <input type="hidden" name="id" id="id" value="{{ $lead_data->id }}" />
                                    @else
                                        <form action="{{ url('/add_lead') }}" id="leadformsubmit" method="POST">
                                    @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="name" name="name" required class="form-control" placeholder="Name" value="{{ isset($lead_data->name) ? $lead_data->name : '' }}">
                                                    <span id="err_name" style="display:none;color: #ff0000;">Please Name</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <input type="email" id="email" name="email" required class="form-control" placeholder="Email" value="{{ isset($lead_data->email) ? $lead_data->email : '' }}" >
                                                    <span id="erremail" style="display:none;color: #ff0000;">Please Enter Email</span>
                                                </div>
                                                <div class="form-group">
                                                	<label>Country</label>
                                                    <select id="country" name="count</div>ry" class="form-control select2" onChange="getstate();">
                                                        <option value="{{ isset($lead_data->country) ? $lead_data->country : '' }}" selected>{{ isset($lead_data->country) ? $lead_data->country : 'Please Select Country' }}</option>
                                                        @if(isset($data['country_data']))
                                                            @foreach($data['country_data'] as $country)
                                                                @php
                                                                    $selected='';

                                                                    if(isset($lead_data->country))
                                                                    {
                                                                        if(strtolower($lead_data->country) == strtolower($country->name))
                                                                        {
                                                                            $selected='selected';
                                                                        }
                                                                    }
                                                                @endphp
                                                                <option value="{{ $country->id }}" {{ $selected }}>{{ $country->name }} </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                 </div>

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Addreess</label>
                                                    <input type="text" id="address" name="address" value="{{ isset($lead_data->address) ? $lead_data->address : '' }}" required class="form-control" placeholder="Address">
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label>Mobile No</label>
                                                    <input type="text" id="mobile" name="mobile" required minlength="10" maxlength="10" class="form-control number" placeholder="Mobile" value="{{ isset($lead_data->mobile) ? $lead_data->mobile : '' }}">
                                                </div> -->


                                                <div class="form-group">
                                                    <label>Mobile No</label>

                                                    <div class="row">
                                                        <div class="col-md-4 p-0">
                                                            <select name="country_code" id="country_code"
                                                                    class="form-control select2" required>
                                                                <option value="">Code</option>

                                                                @foreach($data['country_phone_code'] as $code)
                                                                    <option value="{{ $code->phone_code }}"
                                                                        {{ (isset($lead_data->country_code) && $lead_data->country_code == $code->phone_code) ? 'selected' : '' }}>
                                                                        {{ $code->phone_code }} ({{ $code->iso_code }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-8 p-0">
                                                            <input type="text" id="mobile" name="mobile" required minlength="10" maxlength="10" class="form-control number" placeholder="Mobile" value="{{ isset($lead_data->mobile) ? $lead_data->mobile : '' }}">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">

                                                    <label>State</label>
                                                    <select name="state" id="state" onChange="getcity();" class="form-control select2">
                                                        <option value="" selected>Please Select State</option>
                                                        @foreach($data['state_data'] as $state)
                                                            @php
                                                                $selected='';

                                                                if(isset($lead_data->state))
                                                                {
                                                                    if(strtolower($lead_data->state) == strtolower($state->name))
                                                                    {
                                                                        $selected='selected';
                                                                    }
                                                                }
                                                            @endphp
                                                            <option value="{{ $state->id }}" {{ $selected }}>{{ $state->name }} </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Source </label>
                                                    <select name="contact" id="contact" onchange="getclientlist();" class="form-control" required>
                                                        <option value="Walk-In Client"> Walk-In Client</option>
                                                        <option value="Meta">Meta</option>
                                                        <option value="Offline Agent">Offline Agent</option>
                                                        <option value="Referral Client">Referral Client</option>
                                                    </select>
                                                    <span id="errcontact" style="display:none;color: #ff0000;">Please Select Contact</span>
                                                </div>
                                                <div id="client_list" class="form-group">
                                                    <label>Client List</label>
                                                    <select name="client_id" id="client_id" class="form-control select2">
                                                        <option value="" selected>Please Select Client</option>
                                                        @foreach($client_lists as $clients)
                                                            @php
                                                                $selected='';

                                                                if(isset($lead_data->client_id))
                                                                {
                                                                    if($lead_data->client_id == $clients->id)
                                                                    {
                                                                        $selected='selected';
                                                                    }
                                                                }
                                                            @endphp
                                                            <option value="{{ $clients->id }}" {{ $selected }}>{{ $clients->name }} </option>
                                                        @endforeach
                                                    </select>
                                                    <span id="errclient" style="display:none;color: #ff0000;">Please Select Client</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Followup Date</label>
                                                    <input type="date" id="follow_up_date" name="follow_up_date" required class="form-control" value="{{ date('Y-m-d', strtotime('+3 day')) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <select id="city" name="city" class="form-control select2">
                                                        <option value="{{ isset($lead_data->city) ? $lead_data->city : '' }}" selected>{{ isset($lead_data->city) ? $lead_data->city : 'Please Select City' }}</option>
                                                        @if(isset($data['city_data']))
                                                            @foreach($data['city_data'] as $city)
                                                                @php
                                                                    $selected='';

                                                                    if(isset($lead_data->city))
                                                                    {
                                                                        if(strtolower($lead_data->city) == strtolower($city->name))
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
                                            </div>
                                        </div>

                                        <div class="form-group">


                                                    <label>Zipcode</label>
                                                    <input type="text" id="pincode" name="pincode" minlength="6" maxlength="6" required class="form-control number" placeholder="Zipcode" value="{{ isset($lead_data->pincode) ? $lead_data->pincode : '' }}">
                                                </div>

                                        <div class="form-group" style="display:none">
                                            <label>Lead</label>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <input type="checkbox" id="website_lead" name="lead[]" class="lead_checkbox" value="Web Development"> &nbsp;&nbsp;&nbsp;<label>Web Development</label>
                                                    <br>
                                                    <input type="checkbox" id="android_lead" name="lead[]" class="lead_checkbox" value="Mobile Application">&nbsp;&nbsp;&nbsp;<label>Mobile Application</label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="checkbox" id="digital_marketing" name="lead[]" class="lead_checkbox" value="Digital Marketing"> &nbsp;&nbsp;&nbsp;<label>Digital Marketing</label>
                                                    <br>
                                                    <input type="checkbox" id="soft_consulting" name="lead[]" class="lead_checkbox" value="Software Consulting"> &nbsp;&nbsp;&nbsp;<label>Software Consulting</label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="checkbox" id="soft_test" name="lead[]" class="lead_checkbox" value="Software Testing QA"> &nbsp;&nbsp;&nbsp;<label>Software Testing & QA</label>
                                                    <br>
                                                    <input type="checkbox" id="game_dev" name="lead[]" class="lead_checkbox" value="Game Development"> &nbsp;&nbsp;&nbsp;<label>Game Development</label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="checkbox" id="cloud_dev" name="lead[]" class="lead_checkbox" value="Cloud DevOps"> &nbsp;&nbsp;&nbsp;<label>Cloud & DevOps</label>
                                                    <br>
                                                    <input type="checkbox" id="others" name="lead[]" class="lead_checkbox" value="Others"> &nbsp;&nbsp;&nbsp;<label>Others</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <input type="text" id="remarks" name="remarks" required class="form-control" value="{{ isset($lead_data->id) ? $lead_data->remarks : '' }}">
                                        </div>
                                        <button type="button" id="finalbtn" class="btn btn-primary">Submit</button>
                                        @php
                                            if(isset($lead_data->id))
                                            {
                                                @endphp
                                                <a href="{{ url('/lead_delete').'/'.$lead_data->id }}" class="btn btn-danger">Delete</a>
                                                @php
                                            }
                                        @endphp
                                        <div class="form-group"></div>
                                        <div class="form-group">
                                            @php
                                                if(isset($lead_data->id))
                                                {
                                                    @endphp
                                                    <table width="100%" class="table-striped">
                                                        <thead>
                                                            <th>Date</th>
                                                            <th style="text-align: left;">Remarks</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($lead_data['remarks_data'] as $remarksdata)
                                                                <tr>
                                                                    <td>@php echo date('Y-m-d', strtotime( $remarksdata->created_at)); @endphp</td>
                                                                    <td style="text-align: left;">{{ $remarksdata->remarks }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @php
                                                }
                                            @endphp
                                        </div>
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
        $('#item_id').select2({
            dropdownParent: $('#myModal'),
            width:'100%'
        });

        $('.select2-container').css('display', 'inline-table');
        $('.modal-footer').css('padding', '5px');

        $('.tox-notifications-container').css('display', 'none !important');

        $('#client_list').css('display', 'none');

        $('.summernote').summernote();
    });



    $(".number").on('keypress keyup focusout', function()
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
</script>
<script type="text/javascript">
    $("#finalbtn").click(function()
    {
        var name=$("#name").val();
        $("#client_name").parent().removeClass("has-error");
        if(name=='' || name == null)
        {
            $("#err_name").show(0).delay(3500).hide(0);
            $("#name").parent().addClass("has-error");
            $("#name").focus();
            return false;
        }

        var contact=$("#contact").val();

        if(contact=='')
        {
            $("#errcontact").show(0).delay(3500).hide(0);
        }
        else if(contact=='Reffence')
        {
            var client_id=$("#client_id").val();
            if(client_id=='')
            {
                $("#errclient").show(0).delay(3500).hide(0);
                return false;
            }
        }

        $("#leadformsubmit").submit();
    });

    function getclientlist()
    {
        var contact=$("#contact").val();

        if(contact=='Reffence')
        {
            $("#client_id").prop('disabled', false);
            $("#client_list").css('display', 'block');
        }
        else
        {
            $("#client_id").prop('disabled', true);
            $("#client_list").css('display', 'none');
        }
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
	function getstate()
    {
        var country_id=$("#country").val();
        $("#state").html('');

        $.ajax({
            type : 'POST',
            url : "{{ url('/getStateBycountryId') }}",
            data : {'country_id': country_id, "_token": "{{ csrf_token() }}"},
            success:function(data)
            {
                if(data.state.status_code == 200)
                {
                    var option='<option value="" selected disabled>Please Select State</option>';

                    $.each(data.state.data, function(index,value)
                    {
                        option+='<option value="'+value.id+'">'+value.name+'</option>';
                    });

                    $("#state").html(option);
                }
            }
        });
    }



</script>
@if(isset($lead_data->id))
    <script>
        $(document).ready(function()
        {
            var lead="{{ $lead_data->lead }}";
            lead1=lead.split(',');

            $('.lead_checkbox').each(function()
            {
                if(jQuery.inArray(this.value, lead1) >  -1)
                {
                    $("#"+this.id).prop('checked', true);
                }
            });

            var status="{{ $lead_data->status }}";

            $("#status option").each(function()
            {
                var op_status=$(this).val();
                if(op_status==status)
                {
                    $(this).prop('selected', true);
                }
            });

            var follow_up_date="{{ $lead_data->follow_up_date }}";
            $("#follow_up_date").val(follow_up_date);
        });
    </script>
@endif
@if(isset($lead_data->contact))
    <script>
        $(document).ready(function()
        {
            var lead="{{ $lead_data->lead }}";
            lead1=lead.split(',');

            $('.lead_checkbox').each(function()
            {
                if(jQuery.inArray(this.value, lead1) >  -1)
                {
                    $("#"+this.id).prop('checked', true);
                }
            });

            var contact="{{ $lead_data->contact }}";

            $("#contact option").each(function()
            {
                var op_status=$(this).val();
                if(op_status==contact)
                {
                    $(this).prop('selected', true);
                    if(contact=='Reffence')
                    {
                        getclientlist();
                    }
                }
            });

            var follow_up_date="{{ $lead_data->follow_up_date }}";
            $("#follow_up_date").val(follow_up_date);
        });
    </script>
@endif
@endsection
