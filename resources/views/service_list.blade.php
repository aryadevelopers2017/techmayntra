@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Services Type</h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/home') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Services Type
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.Admin.messages')

            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        <a href="{{ url('/service_add') }}" class="btn btn-primary">
                            Add New Service
                        </a>
                    </div>
                </div>
            </div>

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
                                                <th>Category</th>
                                                <th>Service Name</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach($data as $service)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $service->category_name ?? '-' }}</td>
                                                    <td>{{ $service->name }}</td>
                                                    <td>{{ $service->description }}</td>
                                                    <td>
                                                        @if($service->status == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('/service_edit/'.$service->id) }}"
                                                        class="btn btn-sm btn-info">
                                                            Edit
                                                        </a>

                                                        <a href="{{ url('/service_delete/'.$service->id) }}"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this service?')">
                                                            Delete
                                                        </a>
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
