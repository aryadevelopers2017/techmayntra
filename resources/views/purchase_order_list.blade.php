@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Purchase Order Report</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Purchase Order Report</li>
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
                        <a href="{{ url('/purchase_order_add')}}" class="btn btn-primary">Add New Purchase Order</a>
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
                                            <th style="text-align: left;">Company Name</th>
                                            <th style="text-align: left;">Vendor Name</th>
                                            <th style="text-align: left;">Subject</th>
                                            <th style="text-align: left;">Product</th>
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
                                                    <td style="text-align: left;"><a href="{{ url('purchase_order_generate_invoice').'/'.$item->id }}" title="invoice"><i class="ti-notepad"></i></a></td>
                                                    <td style="text-align: left;"><a href="{{ url('purchase_order_edit').'/'.$item->id }}" title="edit">{{ $item->order_no }}</a></td>
                                                    <td style="text-align: left;">@php echo date('Y-m-d', strtotime($item->purchase_date)); @endphp</td>
                                                    <td style="text-align: left;">{{ $item->company_name }}</td>
                                                    <td style="text-align: left;">
                                                        @if($item->vender_id=='other')
                                                            {{ $item->vender_id }}
                                                        @else
                                                            {{ $item->vendor_name }}
                                                        @endif
                                                    </td>
                                                    <td style="text-align: left;">
                                                        @if($item->vender_id=='other')
                                                            {{ $item->subject }}
                                                        @else
                                                            {{ $item->subject_title }}
                                                        @endif
                                                    </td>
                                                    <td style="text-align: left;">{{ $item->product_name }}</td>
                                                    <td style="text-align: left;">{{ $item->total_amount }}</td>
                                                    <td style="text-align: left;">
                                                        @php
                                                            if($item->status==0)
                                                            {
                                                                $status_word="On hold";
                                                                $status_icon="warning";
                                                            }
                                                            elseif($item->status==1)
                                                            {
                                                                $status_word="Accepted";
                                                                $status_icon="primary";
                                                            }
                                                            else
                                                            {
                                                                $status_word="Rejected";
                                                                $status_icon="danger";
                                                            }
                                                        @endphp
                                                        <span class="badge badge-{{ $status_icon }}">{{ $status_word }}</span>
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