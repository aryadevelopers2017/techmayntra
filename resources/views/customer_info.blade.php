@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Customer Information </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Customer</li>
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
                                                <label>{{ $data->mobile }}</label>
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
                                                <label>City</label>
                                            </div>
                                            <div class="col-md-2"> : </div>
                                            <div class="col-md-6">
                                                <label>{{ $data->city }}</label>
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
                                        <a href="{{ url('/delete_customer').'/'.$data->id }}" class="btn btn-danger btn-sm sweetalert sweet-success-cancel" title="">Delete</a>
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
