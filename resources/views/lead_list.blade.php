@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Lead Master</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 col-md-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Lead Master</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>

            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                         @can('lead.add')
                        <a href="{{ url('/lead_add') }}" class="btn btn-primary">Add New Lead</a>
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
                                    <table id="bootstrap-data-table-export" class="table nowrap table-striped table-bordered">
                                        <thead>
                                            <th>Sr No</th>
                                            <th style="text-align: left;">Name</th>
                                            <th style="text-align: left;">Contact</th>
                                            <th style="text-align: left;">FollowUp Date</th>
                                            <th style="text-align: left;">Last Remarks</th>
                                            <th style="text-align: left;">Status</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($lead_lists as $leads)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td style="text-align: left;">
                                                        @can('lead.edit')
                                                            @if($leads->status == 0)
                                                                <a href="{{ url('/lead_edit/'.$leads->id) }}">
                                                                    {{ $leads->name }}
                                                                </a>
                                                            @else
                                                                {{ $leads->name }}
                                                            @endif
                                                        @else
                                                            {{ $leads->name }}
                                                        @endcan
                                                    </td>

                                                    <td style="text-align: left;">{{ $leads->contact }}</td>
                                                    <td style="text-align: left;">{{ $leads->follow_up_date }}</td>
                                                    <td style="text-align: left;">
                                                        <div>
                                                            @php
                                                                echo chunk_split($leads->remarks, 20, "\n\r");
                                                            @endphp
                                                        </div>
                                                    </td>
                                                    <td style="text-align: left;" >
                                                        @php
                                                            $bgcolor='#fcec03';
                                                            if($leads->status==1)
                                                            {
                                                                $bgcolor='#009933';
                                                            }
                                                            else if($leads->status==2)
                                                            {
                                                                $bgcolor='#ff0000';
                                                            }

                                                            if($leads->status==0)
                                                            {
                                                                $word_status="Pending";
                                                            }
                                                            else if($leads->status==1)
                                                            {
                                                                $word_status="Accept";
                                                            }
                                                            else
                                                            {
                                                                $word_status="Reject";
                                                            }

                                                            if($leads->status!=0)
                                                            {
                                                                @endphp
                                                                <label for="name" class="aceept-text" style="color: {{ $bgcolor }}"> {{ $word_status }} </label>
                                                                @php
                                                            }
                                                            else
                                                            {
                                                                @endphp
                                                                  @can('lead.approve')

                                                                <a href="{{ url('/lead_approve/').'/'.$leads->id }}" class="btn btn-success sweetalert btn sweet-success" title=""><i class="fa fa-check"></i></a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a href="{{ url('/lead_cancel/').'/'.$leads->id }}" class="btn btn-danger btn sweetalert sweet-success-cancel" title=""><i class="fa fa-close"></i></a>
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
