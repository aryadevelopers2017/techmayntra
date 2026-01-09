@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Vendor Information</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Vendor</li>
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

                                    {{-- BASIC INFO --}}
                                    @php
                                        function row($label, $value) {
                                            return '
                                            <div class="row mb-2">
                                                <div class="col-md-4"><label>'.$label.'</label></div>
                                                <div class="col-md-2">:</div>
                                                <div class="col-md-6"><label>'.($value ?: '-').'</label></div>
                                            </div>';
                                        }
                                    @endphp

                                    {!! row('Name', $data->name) !!}
                                    {!! row('Company Name', $data->company_name) !!}
                                    {!! row('Email Address', $data->email) !!}
                                    {!! row('Mobile No', $data->mobile) !!}
                                    {!! row('Address', $data->address) !!}
                                    {!! row('Country', $data->country) !!}
                                    {!! row('State', $data->state) !!}
                                    {!! row('City', $data->city) !!}
                                    {!! row('GST No', $data->gst_no) !!}

                                    {{-- SERVICE & RATE --}}
                                    <hr>
                                    <h5>Service Details</h5>

                                    {!! row('Service', $data->service->name ?? '-') !!}
                                    {!! row('Rate Option', $data->rate_option) !!}

                                    {{-- BANK DETAILS --}}
                                    <hr>
                                    <h5>Bank Details</h5>

                                    {!! row('Bank Name', $data->bank_name) !!}
                                    {!! row('Account Holder Name', $data->account_holder_name) !!}
                                    {!! row('Account Number', $data->account_number) !!}
                                    {!! row('IFSC Code', $data->ifsc_code) !!}
                                    {!! row('Branch Name', $data->branch_name) !!}

                                    {{-- ACTION --}}
                                    <hr>
                                    <a href="{{ url('/delete_vendor/'.$data->id) }}"
                                       class="btn btn-danger btn-sm sweetalert sweet-success-cancel">
                                        Delete Vendor
                                    </a>

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
