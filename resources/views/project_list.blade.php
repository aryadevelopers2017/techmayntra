@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Project </h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project</li>
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
                                                                        @can('project.add')

                        <a href="{{ url('/project_add') }}" class="btn btn-primary">Add New Project</a>
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
                                    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th>Title</th>
                                                <th>Client_Name</th>
                                                <th>Quotation_Price</th>
                                                <th>Vendor_Name</th>
                                                <th>Vendor_Price</th>
                                                <th>Start_Date</th>
                                                <th>Due_Date</th>
                                                <th>Days</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($data as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    @php
                                                        $status_id=$item->status;
                                                        if($status_id==0)
                                                        {
                                                            $status='On Going';
                                                            $status_icon="warning";
                                                        }
                                                        elseif($status_id==1)
                                                        {
                                                            $status='Completed';
                                                            $status_icon="primary";
                                                        }
                                                        else
                                                        {
                                                            $status='Cancel';
                                                            $status_icon="danger";
                                                        }
                                                    @endphp
                                                    <td>
                                                        @if($status_id==0 || $status_id==1)

                                                                        @can('project.edit')

                                                            <a href="{{ url('/project_payment_info').'/'.$item->id }}" title="milestone"> {{$item->quotation_title}}</a>
                                                            @else
                                                            {{$item->quotation_title}}
                                                                            @endcan

                                                        @else
                                                            {{$item->quotation_title}}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ $item->quotation_price }}</td>
                                                    <td>{{ $item->vendor_name }}</td>
                                                    <td>{{ $item->vendor_price }}</td>
                                                    <td>{{ $item->start_date }}</td>
                                                    <td>{{ $item->due_date }}</td>
                                                    <td>{{ $item->remaining_days }} <!-- / {{ $item->extradays }} --></td>
                                                    <td>{{ $item->quotation_price - $item->vendor_price}}</td>
                                                    <td><span class="badge badge-{{ $status_icon }}"> {{ $status }}</span> </td>
                                                    <td>
                                                                        @can('project.status')

                                                        @if($status_id==0)
                                                            <a class="btn btn-success" onClick="approve_project({{ $item->id }});" title="approve"><i class="fa fa-check"></i></a> &nbsp;&nbsp;&nbsp; <a onClick="cancel_project({{ $item->id }});"  class="btn btn-danger" title="cancel"><i class="fa fa-close"></i></a>
                                                        @endif
                                                                                                                                    @endcan

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
            </section>
        </div>
    </div>
</div>
<script>
    function approve_project(id)
    {
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to this project is completed!',
            type: 'green',
            confirmButtonClass:'btn-success',
            cancelButtonClass:'btn-danger',
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function()
                    {
                        var url="{{ url('/project_approve/') }}"+"/"+id;
                        window.location.href=url;
                    }
                },
                close: {
                    btnClass: 'btn-danger',
                    action: function()
                    {
                        $.alert('Canceled!');
                    }
                }
            }
        });
    }

    function cancel_project(id)
    {
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to this project is Cancel!',
            confirmButton:'Okay',
            cancelButton:'Cancel',
            type: 'red',
            confirmButtonClass:'btn-success',
            cancelButtonClass:'btn-danger',
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    action: function()
                    {
                        var url="{{ url('/project_cancel/') }}"+"/"+id;
                        window.location.href=url;
                    }
                },
                close: function ()
                {
                    $.alert('Canceled!');
                }
            }
        });
    }
</script>
@endsection
