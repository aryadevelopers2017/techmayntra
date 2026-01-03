@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Company Address </h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Company Address</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>

            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        <a href="{{ url('/company_address_add') }}" class="btn btn-primary">Add New Address</a>
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
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($address_data as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{$item->address}}</td>
                                                    <td>{{$item->city}}</td>
                                                    <td>{{$item->state}}</td>
                                                    <td>
                                                        @php
                                                            $status=$item->status;
                                                            if($status==0)
                                                            {
                                                                @endphp
                                                                <a href="{{ url('update_address_status').'/'.$item->id }}" class="btn btn-danger">In-Active</a>
                                                                @php
                                                            }
                                                            else
                                                            {
                                                                @endphp
                                                                <a href="{{ url('update_address_status').'/'.$item->id }}" class="btn btn-success">Active</a>
                                                                @php
                                                            }
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
