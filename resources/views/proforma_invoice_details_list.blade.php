@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1> Invoice Report</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
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

            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
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
                                            <th style="text-align: left;">Invoice Action</th>
                                            <th style="text-align: left;">Invoice No</th>
                                            <th style="text-align: left;">Date</th>
                                            <th style="text-align: left;">Title</th>
                                            <th style="text-align: left;">Customer Name</th>
                                            <th style="text-align: left;">Company Name</th>
                                            <th style="text-align: left;">Total Amount</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($proforma_invoice_details as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td style="text-align: left;"><a target="_blank" href="{{ url('/final_invoice/').'/'.$item->id }}" title=""><i class="ti-notepad"></i></a><!-- &nbsp;&nbsp;&nbsp;&nbsp;<a href="/quotation_edit/{{ $item->id }}" title=""><i class="ti-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/quotation_delete/{{ $item->id }}"><i class="ti-trash"></i></a> --></td>
                                                    <td style="text-align: left;">{{ $item->invoice_no }}</td>
                                                    <td style="text-align: left;">{{ $item->entrydate }}</td>
                                                    <td style="text-align: left;">{{ $item->title }}</td>
                                                    <td style="text-align: left;">{{ $item->name }}</td>
                                                    <td style="text-align: left;">{{ $item->company_name }}</td>
                                                    <td style="text-align: left;">{{ $item->total_amount }}</td>
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
