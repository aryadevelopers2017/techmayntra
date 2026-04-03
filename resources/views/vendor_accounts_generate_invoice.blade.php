@extends('layouts.Admin.invoice_app')

@section('content')

<style>
    #receipt {
        max-width: 600px;
        margin: auto;
        border: 1px solid #000;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .header {
        text-align: center;
        border-bottom: 1px solid #000;
        padding-bottom: 10px;
    }

    .header img {
        max-height: 60px;
    }

    .section {
        margin-top: 15px;
    }

    .row-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .total {
        font-weight: bold;
        font-size: 16px;
        border-top: 1px solid #000;
        padding-top: 10px;
        margin-top: 10px;
    }

    .footer {
        margin-top: 30px;
        text-align: right;
    }

    .btn-area {
        text-align: right;
        margin-bottom: 10px;
    }
</style>

<div class="btn-area">
    <button id="pdfdownload" class="btn btn-primary">Generate PDF</button>
</div>

<div id="receipt">

    <!-- Header -->
    <div class="header">
        <img src="{{ asset('asset/images/'.$company_data->company_logo) }}" alt="">
        <h3>{{ $company_data->company_name }}</h3>
        <p>{{ $company_data->address }}</p>
    </div>

    <!-- Receipt Info -->
    <div class="section">
        <div class="row-line">
            <span><b>Receipt No:</b> {{ $data->order_no }}</span>
            <span><b>Date:</b> {{ $data->date }}</span>
        </div>
    </div>

    <!-- Vendor -->
    <div class="section">
        <p><b>Received From:</b></p>
        <p>{{ $vendor->name ?? '' }}</p>
        <p>{{ $data->company_name }}</p>
        <p>
            {{ $city->name ?? '' }},
            {{ $state->name ?? '' }},
            {{ $country->name ?? '' }}
        </p>
    </div>

    <!-- Description -->
    <div class="section">
        <p><b>Description:</b></p>
        <p>{{ $data->description }}</p>
    </div>

    <!-- Amount -->
    <div class="section">
        <div class="row-line">
            <span>Amount</span>
            <span>{{ $currency_data->symbol  }} {{ number_format($data->total_amount, 2) }}</span>
        </div>

        <div class="row-line total">
            <span>Total</span>
            <span>{{ $currency_data->symbol  }} {{ number_format($data->total_amount, 2) }}</span>
        </div>
    </div>

    <!-- Amount in words -->
    <div class="section">
        <p><b>Amount in Words:</b> {{ $data->amount_word ?? '' }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>For {{ $company_data->company_name }}</p>
        <br><br>
        <p>Authorised Signatory</p>
    </div>

</div>

<!-- PDF Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    var invoice_no = "{{ $data->order_no }}";

    document.getElementById("pdfdownload").onclick = function() {
        this.innerText = "Generating...";

        var element = document.getElementById("receipt");

        html2pdf().from(element).set({
            margin: 10,
            filename: invoice_no + '.pdf',
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                format: 'a4',
                orientation: 'portrait'
            }
        }).save();

        this.innerText = "Generate PDF";
    };
</script>

@endsection
