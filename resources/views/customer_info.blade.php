@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Client Information </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Client</li>
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
                                    <form>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->name }}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Company Name</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->company_name }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Email Address</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->email }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Mobile No</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->country_code }} {{ $data->mobile }} </label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Addreess</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->address }}</label>
                                            </div>
                                        </div>

                                          <div class="row">
                                            <div class="col-md-4">
                                                <label>Country</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->country }}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>State</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->state }}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>City</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->city }}</label>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Departure Date</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->departure_date }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Return Date</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->return_date }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Travel Country</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->getTravelCountryName() }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Travel State</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->getTravelStateName() }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Travel City</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->getTravelCityName() }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Assigned Staff</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->getAssignedStaffName() }}</label>
                                            </div>
                                        </div>

                                       <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label>Documents</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                @php
                                                    $documents = $data->getDocumentsGrouped();
                                                @endphp

                                                @if($documents->count())
                                                    @foreach($documents as $type => $files)
                                                        <div class="mb-2">
                                                            <strong>{{ ucfirst(str_replace('_',' ', $type)) }}:</strong>
                                                            <ul class="mb-0">
                                                                @foreach($files as $file)
                                                                    <li>
                                                                        <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">
                                                                            View Document
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Quotation</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->total_quotation }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Proforma</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->total_proforma }}</label>
                                            </div>
                                        </div>

                         @can('client-delete')

                                        <a href="{{ url('/delete_customer').'/'.$data->id }}" class="btn btn-danger btn-sm sweetalert sweet-success-cancel" title="">Delete</a>
@endcan

                         @can('client-edit')

                                        <a href="{{ url('/edit_customer').'/'.$data->id }}" class="btn btn-primary  btn-sm " title="">Edit</a>
@endcan

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
