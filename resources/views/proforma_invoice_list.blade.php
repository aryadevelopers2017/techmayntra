@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1> Invoice Report</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 col-md-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active"> Invoice Report</li>
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


                    @can('invoice.add')

                        <a href="{{ url('/invoice_add')}}" class="btn btn-primary">Add New Invoice</a>

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
                                    <table id="bootstrap-data-table-export" class="table display responsive nowrap table-striped table-bordered">
                                        <thead>
                                            <th>Sr.No</th>
                                            <!-- <th style="text-align: left;">Proforma Action</th> -->
                                            <th style="text-align: left;">Proforma No</th>
                                            <th style="text-align: left;">Date</th>
                                            <th style="text-align: left;">Title</th>
                                            <th style="text-align: left;">Name</th>
                                            <th style="text-align: left;">Company Name</th>
                                            <th style="text-align: left;">Currency</th>
                                            <th style="text-align: left;">Total Amount</th>
                                            <th style="text-align: left;">Status</th>
                                            <th style="text-align: left;">Action</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($proforma_invoice_list as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <!-- <td style="text-align: left;"><a href="{{ url('/proforma_invoice_generate/').'/'.$item->id }}" title=""><i class="ti-notepad"></i><a target="_blank" href="/invoice/{{ $item->id }}" title=""><i class="ti-notepad"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/quotation_edit/{{ $item->id }}" title=""><i class="ti-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/quotation_delete/{{ $item->id }}"><i class="ti-trash"></i></a></td> -->
                                                    <td style="text-align: left;">
                                                        @php
                                                            if($item->status==0 || $item->status==1)
                                                            {
                                                                @endphp
                                                                   @can('invoice.print')

                                                                <a href="{{ url('/proforma_invoice_generate/').'/'.$item->id }}" title="invoice" target="_blank">{{ $item->invoice_no }}</a>

@else
{{ $item->invoice_no }}

                                                                                    @endcan

                                                                @php
                                                            }
                                                            else
                                                            {
                                                                echo $item->invoice_no;
                                                            }
                                                        @endphp
                                                    </td>
                                                    <td style="text-align: left;">{{ $item->entrydate }}</td>
                                                    <td style="text-align: left;">{{ $item->title }}</td>
                                                    <td style="text-align: left;">{{ $item->name }}</td>
                                                    <td style="text-align: left;">{{ $item->company_name }}</td>
                                                    <td style="text-align: left;">{{ $item->code }}</td>
                                                    <td style="text-align: left;">{{ $item->symbol }} {{ $item->total_amount }}</td>
                                                    <td style="text-align: left;">
                                                        @php
                                                            $status=$item->status;

                                                            if($status==0)
                                                            {
                                                                $status_word="Pending";
                                                                $status_icon="warning";
                                                            }
                                                            else if($status==1)
                                                            {
                                                                $status_word="Approve";
                                                                $status_icon="primary";
                                                            }
                                                            else
                                                            {
                                                                $status_word="Cancel";
                                                                $status_icon="danger";
                                                            }
                                                        @endphp
                                                        <span class="badge badge-{{ $status_icon }}">{{ $status_word }}</span>
                                                    </td>
                                                    <td>



                                                        @php
                                                            $total_amount=$item->total_amount;
                                                            $paid_amount=$item->paid_amount;
                                                            if($item->status==0)
                                                            {
                                                                @endphp
                                                                   @can('invoice.approve')
                                                                <a href="{{ url('/proforma_invoice_approve/').'/'. $item->id }}" class="btn btn-success sweetalert btn sweet-success" title="approve"><i class="fa fa-check"></i></a> &nbsp;&nbsp;&nbsp;
                                                                <a href="{{ url('/proforma_invoice_cancel/').'/'. $item->id }}" class="btn btn-danger btn sweetalert sweet-success-cancel" title="cancel"><i class="fa fa-close"></i></a>
                                                                    @endcan

                                                                @php
                                                            }
                                                            elseif($item->status==1 && $total_amount>$paid_amount)
                                                            {
                                                                @endphp
                                                                   @can('invoice.payment_add')

                                                                <a href="{{ url('/proforma_invoice_payment/').'/'.$item->id }}" class="btn btn-primary" title="payment">Payment</a>
                                                                                    @endcan

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
