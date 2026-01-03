@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Company Address </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add New Company Address</li>
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
                                    @if(isset($details_array['quotation_id']))
                                        <form action="{{ url('/add_company_address') }}" method="POST">
                                            <input type="hidden" name="id" id="id" value="{{ $company['quotation_id'] }}" />
                                    @else
                                        <form action="{{ url('/add_company_address') }}" method="POST">
                                    @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="form-group">
                                            <label>Select Company </label>
                                            <select id="company_id" name="company_id" class="form-control select2" required>
                                                <option value="">Please Select Company</option>
                                                @foreach($company as $company_data)
                                                    <option value="{{ $company_data->id }}">{{ $company_data->company_name }}</option>
                                                @endforeach
                                            </select>
                                            <span id="errcompany" style="display:none;color: #ff0000;">Please Select Company</span>
                                        </div>

                                        <div class="form-group">
                                            <label>Address </label>
                                            <textarea name="address" class="form-control" style="height: 100px !important;" id="address" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>City </label>
                                            <input type="text" name="city" value="" id="city" class="form-control" placeholder="Please Enter City" required>
                                        </div>
                                        <div class="form-group">
                                            <label>State </label>
                                            <input type="text" name="state" value="" id="state" class="form-control" placeholder="Please Enter State" required>
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
@endsection