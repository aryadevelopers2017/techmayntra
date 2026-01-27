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
                            <h1>
                                Assigned Customers - {{ $user->name }}
                            </h1>
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
                                    Assigned Customers
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.Admin.messages')

         <!-- Assign New Customer Button -->
<div class="row mb-3">
    <div class="col-lg-12">
                                                                                @can('staff.assign_customer')

        <button class="btn btn-primary" data-toggle="modal" data-target="#assignCustomerModal">
            Assign New Customer
        </button>
                                                                                    @endcan

    </div>
</div>


<!-- Assign Customer Modal -->
<div class="modal fade" id="assignCustomerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('customer.assign') }}" method="POST">
            @csrf
            <input type="hidden" name="staff_id" value="{{ $user->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Assign Customer to {{ $user->name }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Customer</label>
                        <select name="customer_id" class="form-control" required>
                            <option value="">-- Select Customer --</option>
                            @foreach($allCustomers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }} ({{ $customer->company_name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Assign
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


            <!-- Table -->
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Mobile</th>
                                                <th>Email</th>

                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($customers as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        <a href="{{ url('/customer_info/'.$item->id) }}">
                                                            {{ $item->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $item->company_name }}</td>
                                                    <td>{{ $item->mobile }}</td>
                                                    <td>{{ $item->email }}</td>

                                                    <td class="text-center">
                                                                                                               @can('staff.assign_customer')

                                                        <form action="{{ route('customer.unassign', $item->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Unassign this customer?');">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-sm">
                                                                <i class="fa fa-times"></i> Unassign
                                                            </button>
                                                        </form>
                                                                                                                                    @endcan

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-danger">
                                                        No customers assigned
                                                    </td>
                                                </tr>
                                            @endforelse
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
