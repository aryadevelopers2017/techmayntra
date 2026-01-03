@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Quotation Report</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Quotation Report</li>
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
                        <a href="{{ url('/quotation_add')}}" class="btn btn-primary">Add New Quotation</a>
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
                                            <th style="text-align: left;">No</th>
                                            <th style="text-align: left;">Date</th>
                                            <th style="text-align: left;">Title</th>
                                            <th style="text-align: left;">Name</th>
                                            <th style="text-align: left;">Company Name</th>
                                            <th style="text-align: left;">Currency</th>
                                            <th style="text-align: left;">Amount</th>
                                            <th style="text-align: left;">GST</th>
                                            <th style="text-align: left;">Status</th>
                                            <th style="text-align: left;">Action</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($quotation_list as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td style="text-align: left;"><a target="_blank" href="{{ url('/invoice/').'/'.$item->id }}" title="Invoice"><i class="ti-notepad"></i> &nbsp;&nbsp;&nbsp;{{ $item->invoice_no }}</a></td>
                                                    <td style="text-align: left;">@php echo date('Y-m-d', strtotime($item->entrydate)); @endphp</td>
                                                    <td style="text-align: left;">
                                                        @php
                                                            if($item->quotation_status==0)
                                                            {
                                                                @endphp
                                                                <a href="{{ url('/quotation_edit').'/'.$item->id }}" title="edit"><i class="ti-pencil"></i>&nbsp;&nbsp;&nbsp; {{ $item->title }}</a>
                                                                @php
                                                            }
                                                            else
                                                            {
                                                                echo $item->title;
                                                            }
                                                        @endphp
                                                    </td>
                                                    <td style="text-align: left;">{{ $item->name }}</td>
                                                    <td style="text-align: left;">{{ $item->company_name }}</td>
                                                    <td style="text-align: left;">{{ $item->code }}</td>
                                                    <td style="text-align: left;">{{ $item->symbol }} {{ $item->total_amount }} </td>
                                                    <td style="text-align: left;">
                                                        @php
                                                            $gst=$item->gst_per;

                                                            if($gst>0)
                                                            {
                                                                echo "Yes";
                                                            }
                                                            else
                                                            {
                                                                echo "No";
                                                            }
                                                        @endphp
                                                    </td>
                                                    <td style="text-align: left;">
                                                        @php
                                                            $status=$item->quotation_status;

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
                                                    <td style="text-align: center;width: 150px;">
                                                        <!-- <a target="_blank" href="{{ url('/invoice/').'/'.$item->id }}" title=""><i class="ti-notepad"></i></a>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                                        <!-- @php
                                                            if($item->quotation_status==0)
                                                            {
                                                                @endphp
                                                                <a href="{{ url('/quotation_edit').'/'.$item->id }}" title=""><i class="ti-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="{{ url('/quotation_delete/').'/'.$item->id }}"><i class="ti-trash"></i></a>
                                                                @php
                                                            }
                                                        @endphp -->
                                                        @php
                                                            if($item->quotation_status==0)
                                                            {
                                                                @endphp
                                                                <!-- <button type="button" class="btn btn-success sweetalert btn sweet-success">Approve</button>

                                                                <button type="button" class="btn btn-danger sweetalert btn sweet-success-cancel">Cancel</button> -->
                                                                
                                                                <a href="{{ url('/quotation_approve/').'/'.$item->id }}" class="btn btn-success sweetalert btn sweet-success" title="approve"><i class="fa fa-check"></i></a> &nbsp;&nbsp;&nbsp;
                                                                <a href="{{ url('/quotation_cancel/').'/'.$item->id }}" class="btn btn-danger btn sweetalert sweet-success-cancel" title="cancel"><i class="fa fa-close"></i></a>
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
