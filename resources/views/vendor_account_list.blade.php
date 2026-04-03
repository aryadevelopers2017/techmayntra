@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-6  p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Vendor Account List</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 col-md-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Vendor Account</li>
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

                        <!-- @can('vendor_receipt.add') -->

                        <a href="{{ route('vendor_accounts.create') }}" class="btn btn-primary">Add New
                            Vendor Account</a>

                        <!-- @endcan -->

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
                                            <th>Sr</th>
                                            <th style="text-align: left;">PO</th>
                                            <th style="text-align: left;">No</th>
                                            <th style="text-align: left;">Date</th>
                                            <th style="text-align: left;">Vendor Name</th>
                                            <th style="text-align: left;">Amount</th>
                                            <th style="text-align: left;">Status</th>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i=1;
                                            @endphp
                                            @foreach($data as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td style="text-align: left;">


                                                    <a href="{{ url('vendor_accounts_generate_invoice').'/'.$item->id }}" title="invoice"><i class="ti-notepad"></i></a>

                                                </td>
                                                <td style="text-align: left;">

                                                    <a href="{{ route('vendor_accounts.edit', $item->id) }}" title="edit">
                                                        {{ $item->order_no }}
                                                    </a>

                                                </td>
                                                <td style="text-align: left;">{{ $item->vendor->name ?? 'N/A' }}</td>

                                                <td style="text-align: left;">@php echo date('Y-m-d', strtotime($item->date)); @endphp</td>

                                                <td style="text-align: left;">{{ $item->total_amount }}</td>
                                                <td style="text-align: left;">
                                                    @if($item->status == 1)
                                                    <span class="badge badge-success">Paid</span>
                                                    @else
                                                    <span class="badge badge-warning">Pending</span>
                                                    @endif
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
