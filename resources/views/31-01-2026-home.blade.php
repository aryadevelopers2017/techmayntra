@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Hello, <span>{{ Auth::user()->name }} </span></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">Home</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section id="main-content">
                <div class="row">

                    <div class="col-lg-3">
                        <a href="{{ url('/customer') }}">
                            <div class="card p-0">
                                <div class="stat-widget-three home-widget-three">
                                    <div class="stat-icon bg-facebook">
                                        <i class="ti-user"></i>
                                    </div>
                                    <div class="stat-content widget">
                                        <div class="stat-text">Customer</div>
                                        <div class="stat-digit">{{ $data['customer_data'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <div class="card p-0">
                            <div class="stat-widget-three home-widget-three">
                                <div class="stat-icon bg-facebook">
                                    <i class="fa fa-inr"></i>
                                </div>
                                <div class="stat-content widget">
                                    <div class="stat-text">Approved Amount</div>
                                    <div class="stat-digit">{{ $data['approved_amount'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card p-0">
                            <div class="stat-widget-three home-widget-three">
                                <div class="stat-icon bg-facebook">
                                    <i class="fa fa-inr"></i>
                                </div>
                                <div class="stat-content widget">
                                    <div class="stat-text">Non GST Amount</div>
                                    <div class="stat-digit">{{ $data['without_total_gst_amt'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card p-0">
                            <div class="stat-widget-three home-widget-three">
                                <div class="stat-icon bg-facebook">
                                    <i class="fa fa-inr"></i>
                                </div>
                                <div class="stat-content widget">
                                    <div class="stat-text">Received Amount</div>
                                    <div class="stat-digit">{{ $data['paid_amount'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card p-0">
                            <div class="stat-widget-three home-widget-three">
                                <div class="stat-icon bg-facebook">
                                    <i class="fa fa-inr"></i>
                                </div>
                                <div class="stat-content widget">
                                    <div class="stat-text">Actual Amount</div>
                                    <div class="stat-digit">{{ $data['actual_amount'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card p-0">
                            <div class="stat-widget-three home-widget-three">
                                <div class="stat-icon bg-youtube">
                                    <i class="fa fa-percent"></i>
                                </div>
                                <div class="stat-content widget">
                                    <div class="stat-text">GST Amount</div>
                                    <div class="stat-digit">{{ $data['gst_amt'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-3">
                        <a href="{{ url('/quotation/0') }}">
                            <div class="card p-0">
                                <div class="stat-widget-three home-widget-three">
                                    <div class="stat-icon bg-facebook">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    <div class="stat-content widget">
                                        <div class="stat-text">Quotation</div>
                                        <div class="stat-digit">{{ $data['total_quotation_count'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{ url('/proforma_invoice') }}">
                            <div class="card p-0">
                                <div class="stat-widget-three home-widget-three">
                                    <div class="stat-icon bg-facebook">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    <div class="stat-content widget">
                                        <div class="stat-text">Pro Invoice</div>
                                        <div class="stat-digit">{{ $data['total_proforma_count'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3">
                        <a href="{{ url('/invoice_list/0') }}">
                            <div class="card p-0">
                                <div class="stat-widget-three home-widget-three">
                                    <div class="stat-icon bg-facebook">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    <div class="stat-content widget">
                                        <div class="stat-text">Invoice</div>
                                        <div class="stat-digit">{{ $data['total_invoice_count'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer">
                            <p>2023 © Admin Board. - <a href="#">techmayntra.com</a></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
