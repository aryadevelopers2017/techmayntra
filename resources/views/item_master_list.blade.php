@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Service Master</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Service Master</li>
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
                        <a href="{{ url('/service_master_add') }}" class="btn btn-primary">Add New Service</a>
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
                                            <th style="text-align: left;">Item Name</th>
                                            <th style="text-align: left;">Description</th>
                                            <th style="text-align: left;">Action</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($item_list as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td style="text-align: left;"><a href="{{ url('/service_master_edit').'/'.$item->id }}">{{ $item->item_name }}</a></td>
                                                    <td style="text-align: left;">@php echo strip_tags( $item->description); @endphp</td>
                                                    <td style="text-align: left;"><a href="{{ url('/item_cancel/').'/'.$item->id }}" class="btn btn-danger btn sweetalert sweet-success-cancel" title=""><i class="fa fa-close"></i></a></td>
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
