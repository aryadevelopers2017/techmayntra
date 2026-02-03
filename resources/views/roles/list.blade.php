@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Roles</h1>
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
                                <li class="breadcrumb-item active">Roles</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.Admin.messages')

            <!-- Action Button -->
            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        <a href="{{ url('/roles/add') }}" class="btn btn-primary">
                            Add New Role
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive">
                                    <table id="bootstrap-data-table-export"
                                           class="table table-striped table-bordered">

                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Role Name</th>
                                                <th class="text-left">Permissions</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach($roles as $role)
                                                <tr>
                                                    <td>{{ $i++ }}</td>

                                                    <td>
                                                        <strong>{{ ucfirst($role->name) }}</strong>
                                                    </td>

                                                    <td class="text-left">
                                                        @foreach($role->permissions as $perm)
                                                            <span class="badge badge-info mb-1">
                                                                {{ $perm->name }}
                                                            </span>
                                                        @endforeach
                                                    </td>

                                                    <td class="text-left">
                                                        <a href="{{ url('roles/edit/'.$role->id) }}"
                                                           class="btn btn-info btn-sm">
                                                            Edit
                                                        </a>

                                                        <form action="{{ url('roles/delete') }}"
                                                              method="POST"
                                                              style="display:inline-block;">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $role->id }}">
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure?')">
                                                                Delete
                                                            </button>
                                                        </form>
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
