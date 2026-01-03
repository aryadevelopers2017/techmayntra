@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Client Master</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Client Master</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>

            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        <a href="{{ url('/client_add') }}" class="btn btn-primary">Add New Client</a>
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
                                            <th>Sr No</th>
                                            <th style="text-align: left;">Client Name</th>
                                            <th style="text-align: left;">Company Name</th>
                                            <th style="text-align: left;">Mobile</th>
                                            <th style="text-align: left;">Email</th>
                                            <th style="text-align: left;">Address</th>
                                            <th style="text-align: left;">City</th>
                                            <th style="text-align: left;">State</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($client_lists as $clients)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td style="text-align: left;">{{ $clients->client_name }}</td>
                                                    <td style="text-align: left;">{{ $clients->company_name }}</td>
                                                    <td style="text-align: left;">{{ $clients->mobile }}</td>
                                                    <td style="text-align: left;">{{ $clients->email }}</td>
                                                    <td style="text-align: left;">{{ $clients->address }}</td>
                                                    <td style="text-align: left;">{{ $clients->city }}</td>
                                                    <td style="text-align: left;">{{ $clients->state }}</td>
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
