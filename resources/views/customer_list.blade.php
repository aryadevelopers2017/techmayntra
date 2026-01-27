@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Customer </h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
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
                <!-- /# column -->
            </div>
            @include('layouts.Admin.messages')
            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                         @can('customer-create')
                        <a href="{{ url('/customer_add') }}" class="btn btn-primary">Add New Customer</a>
                        @endcan
                    </div>
                </div>
            </div>
            <!-- /# row -->
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive">
                                    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Name</th>
                                                <th>Company Name</th>
                                                <th>Mobile</th>
                                                <th>Email-ID</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($customer as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td style="text-align:left;">

                                                        <a href="{{ url('/customer_info/'.$item->id) }}">
                                                            {{ $item->name }}
                                                        </a>

                                                    </td>

                                                    <td>{{$item->company_name}}</td>
                                                    <td>{{$item->mobile}}</td>
                                                    <td>{{$item->email}}</td>
                                                    <td>{{ strip_tags($item->address)}}</td>
                                                    <td>{{$item->city}}</td>
                                                    <td>{{$item->state}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
            </section>
        </div>
    </div>
</div>
@endsection
