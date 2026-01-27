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
                            <h1>Add New Role</h1>
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
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/roles') }}">Roles</a>
                                </li>
                                <li class="breadcrumb-item active">Add Role</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">

                                    <form method="POST" action="{{ url('/roles/store') }}">
                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-6">

                                                <!-- Role Name -->
                                                <div class="form-group">
                                                    <label>Role Name</label>
                                                    <input type="text"
                                                           name="name"
                                                           class="form-control"
                                                           placeholder="Enter Role Name"
                                                           required>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Assign Users -->
                                        <div class="row mt-4">
                                            <div class="col-lg-12">
                                                <label><strong>Assign Users</strong></label>
                                                <div class="row">
                                                    @foreach($users as $user)
                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox"
                                                                        name="users[]"
                                                                        value="{{ $user->id }}">
                                                                    {{ $user->name }} ({{ $user->email }})
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Permissions -->
                                        <div class="row mt-3">
                                            <div class="col-lg-12">
                                                <label><strong>Assign Permissions</strong></label>
                                                <div class="row">
                                                    @foreach($permissions as $permission)
                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox"
                                                                           name="permissions[]"
                                                                           value="{{ $permission->name }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit -->
                                        <button type="submit" class="btn btn-primary mt-4">
                                            Save Role
                                        </button>

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
