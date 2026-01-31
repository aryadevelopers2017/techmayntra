@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Project Information </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project Info</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{ url('/project_milestone_add') }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        @php
                                            $customer=$data['customer_data'];
                                            $vendor=$data['vendor_data'];
                                            $quotation =$data['quotation_data'];
                                            $project_milestone =$data['project_milestone_data'];
                                        @endphp
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="hidden" name="project_id" id="project_id" value="{{ $data->id }}">
                                                <fieldset style="border: 1px solid #000000;">
                                                    <legend style="width:18% !important;font-size: 16px;">&nbsp;Client</legend>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Name</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $customer->name }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Company Name</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $customer->company_name }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Email</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $customer->email }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Mobile No</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $customer->mobile }}</label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-6">
                                                <fieldset style="border: 1px solid #000000;">
                                                    <legend style="width:14% !important;font-size: 16px;">&nbsp;Vendor&nbsp;</legend>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Name</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $vendor->name }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Company Name</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $vendor->company_name }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Email</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $vendor->email }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Mobile No</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $vendor->mobile }}</label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <fieldset style="border: 1px solid #000000;">
                                                    <legend style="width:14% !important;font-size: 16px;">&nbsp;Project</legend>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Title</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <label>{{ $data->quotation_title }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Quotation</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <a target="_blank" href="{{ url('/quotation').'/'.$data->quotation_id }}">Go To quotation</a>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Invoice</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <a target="_blank" href="{{ url('/invoice_list').'/'.$data->quotation_id }}">Go To invoice</a>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Vendor Receipt</label>
                                                        </div>
                                                        <div class="col-md-2"> : </div>
                                                        <div class="col-md-6">
                                                            <a target="_blank" href="{{ url('/purchase_order_project_list').'/'.$data->id }}">Go To Vendor Receipt</a>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        @php
                                            $milestone=str_replace('<p>','',$quotation->milestone);
                                            $milestone_arr=explode('</p>',$milestone);
                                            $i=0;
                                        @endphp

                                        @if(isset($milestone_arr))
                                            @foreach($milestone_arr as $milestonedata)
                                                @if(strip_tags($milestonedata)!='')
                                                    @php
                                                        $start_date='';
                                                        $due_date='';
                                                        $remarks='';
                                                        $milestonedata=strip_tags($milestonedata);
                                                        $i++;
                                                    @endphp
                                                    @if(isset($project_milestone[$milestonedata]))
                                                        @php
                                                            $start_date=$project_milestone[$milestonedata]->start_date;
                                                            $due_date=$project_milestone[$milestonedata]->due_date;
                                                            $remarks=$project_milestone[$milestonedata]->remarks;
                                                        @endphp
                                                    @endif

                                                    <fieldset class="mt-2 pt-2" style="border: 1px solid #000;">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <p>{{ $milestonedata }}</p>
                                                                <input type="hidden" class="form-control" name="milestone_no_{{ $i }}" value="{{ $i }}">
                                                                <input type="hidden" class="form-control" name="milestone_{{ $i }}" value="{{ strip_tags($milestonedata) }}">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <p>Start Date</p>
                                                                <input type="date" class="form-control" name="start_date{{ $i }}" id="start_date{{ $i }}" value="{{ $start_date }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p>Due Date</p>
                                                                <input type="date" class="form-control" name="due_date{{ $i }}" id="due_date{{ $i }}" value="{{ $due_date }}">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <p>Remarks</p>
                                                                <input type="text" class="form-control" name="remarks{{ $i }}" id="remarks{{ $i }}" value="{{ $remarks }}">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                @endif
                                            @endforeach
                                        @endif
                                        <input type="hidden" class="form-control" name="total_milestone" value="{{ $i }}">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
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
