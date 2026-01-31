@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>User</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Staff</li>
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
                                                                                                @can('staff.add')

                                                                                                 <a href="{{ url('/staff_add') }}" class="btn btn-primary">Add New Staff</a>

                                                                                                    @endcan

                                                                                                                                                                            @can('service.edit')


                        <a href="{{ url('/roles') }}" class="btn btn-primary">Manage Roles</a>
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
                                                <th class="text-left">Email-ID</th>
                                                <th class="text-left">Assigned Clients</th>
                                                <th class="text-left">Report</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{$user->name}}</td>
                                                    <td class="text-left">{{$user->email}}</td>
                                                    <td class="text-left">
                                                                                                                                @can('staff.assign_customer_list')

                                                        <a href="{{ url('assign-customers/'.$user->id) }}"
                                                        class="btn btn-danger btn-sm">
                                                            Assign Clients
                                                        </a>
                                                                                                                                    @endcan

                                                    </td>
                                                    <td class="text-left">

                                                                                                                            @can('staff.view_report')

                                                        <a href="{{ url('staff-report/'.$user->id) }}"
                                                        class="btn btn-success btn-sm">
                                                            View Report
                                                        </a>
                                                                                                                                    @endcan

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
