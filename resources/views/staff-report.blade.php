@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>
                                Staff Receipt Report
                                <small style="font-size:14px;">
                                    ({{ $user->name }})
                                </small>
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/home') }}">Dashboard</a>
                                </li>

                                <li class="breadcrumb-item active">
                                   Staff Receipt Report
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row mb-3">

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Month Earnings</h5>
                                @foreach($monthTotals as $total)
                                    <p>
                                        {{ $total->symbol }}
                                        {{ number_format($total->total, 2) }}
                                        ({{ $total->code }})
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Year Earnings</h5>
                                @foreach($yearTotals as $total)
                                    <p>
                                        {{ $total->symbol }}
                                        {{ number_format($total->total, 2) }}
                                        ({{ $total->code }})
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>



            {{-- Filter Section --}}
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="">
                                <div class="row">

                                    <div class="col-md-3">
                                        <label>Month</label>
                                        <select name="month" class="form-control" onchange="this.form.submit()">
                                            @for($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Year</label>
                                        <select name="year" class="form-control" onchange="this.form.submit()">
                                            @for($y = date('Y'); $y >= 2020; $y--)
                                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Invoice Table --}}
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive">
                                    <table id="bootstrap-data-table-export"
                                           class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th style="text-align:left;">Invoice No</th>
                                                <th style="text-align:left;">Date</th>
                                                <th style="text-align:left;">Title</th>
                                                <th style="text-align:left;">Name</th>
                                                <th style="text-align:left;">Company Name</th>
                                                <th style="text-align:left;">Currency</th>
                                                <th style="text-align:left;">Total Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php $i = 1; @endphp

                                            @foreach($list_data as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>

                                                    <td style="text-align:left;">
                                                        <a target="_blank"
                                                           href="{{ url('/final_invoice/'.$item->id) }}">
                                                            {{ $item->invoice_no }}
                                                        </a>
                                                    </td>

                                                    <td style="text-align:left;">
                                                        {{ date('d-m-Y', strtotime($item->entrydate)) }}
                                                    </td>

                                                    <td style="text-align:left;">
                                                        {{ $item->title }}
                                                    </td>

                                                    <td style="text-align:left;">
                                                        {{ $item->name }}
                                                    </td>

                                                    <td style="text-align:left;">
                                                        {{ $item->company_name }}
                                                    </td>

                                                    <td style="text-align:left;">
                                                        {{ $item->code }}
                                                    </td>

                                                    <td style="text-align:left;">
                                                        {{ $item->symbol }} {{ number_format($item->total_amount, 2) }}
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
