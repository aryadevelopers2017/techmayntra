<style>
    .modal-backdrop
    {
        background-color: rgba(0, 0, 0, 0.4) !important;;
        -webkit-transition: 0.5s;
        overflow: auto;
        transition: all 0.3s linear;
    }
    body
    {
        margin: 10px !important;
    }
    .loader
    {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    table { page-break-after:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    td    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }

    /* Safari */
    @-webkit-keyframes spin
    {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin
    {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@extends('layouts.Admin.invoice_app')

@section('content')
    <div id="app">
        <div class="row">
            <div class="col-md-11" style="text-align: right;">
                <button id="pdfdownload" class="btn btn-primary">Generate PDF</button>
            </div>
        </div>
        <div class="unix-invoice" id="unix-invoice">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div id="invoice" class="effect2 m-t-10">
                            <div id="invoice-top">
                                <div class="invoice-logo">
                                    <img  id="invoice-logo" src="{{ asset('asset/images/'.$data['company_data']->company_logo) }}" height="50px" alt=""/>
                                </div>
                                <!--End Info-->
                                <div class="title">
                                    <h6>Quotation : {{ $data['invoice_no'] }}</h6>
                                    <p>Issued : {{ $data['entrydate'] }}<br>Open Till : {{ $data['open_date'] }}
                                    </p>
                                </div>
                                <!--End Title-->
                            </div>
                            <!--End InvoiceTop-->
                            <div class="row">
                                <div class="col-md-6" style="text-align: left;">
                                    <h2 style="font-size:14px !important;">{{ $data['company_data']->company_name }}</h2>
                                    @php echo $data['company_address']; @endphp
                                    <p>{{ $data['company_city'].','. $data['company_state'] }} </p>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <h2 style="font-size:14px !important;">To, {{ $data['customer_company_name'] }}</h2>
                                    <p>{{ $data['customer_name'] }}</p>
                                    <p>{{ strip_tags($data['address']) }}<br> {{ $data['city'] }}, {{ $data['state'] }}<br></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h2 style="font-size: 16px;">Quotation - {{ $data['title'] }} </h2>
                                </div>
                            </div>
                            <!--End Invoice Mid-->
                            <div id="invoice-bot">
                                <div id="invoice-table">
                                    <div class="table-responsive">
                                        <table class="table" style="width: 99%!important;">
                                            <tr class="tabletitle1">
                                                <td class="Hours">
                                                    <h2>#</h2>
                                                </td>
                                                <td class="table-item">
                                                    <h2>Description</h2>
                                                </td>
                                                <td class="Rate">
                                                    <h2>Rate</h2>
                                                </td>
                                                <td class="Hour">
                                                    <h2>Qty</h2>
                                                </td>
                                                <td class="subtotal">
                                                    <h2 style="margin-right: 10px;">Amount</h2>
                                                </td>
                                            </tr>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach($data['item_data'] as $item )
                                                <tr class="service1">
                                                    <td class="tableitem">
                                                        {{ $i++ }}
                                                    </td>
                                                    <td class="tableitem">
                                                        <label style="font-weight: 500;margin-bottom: 0px!important;"> {{ $item->item_name }}</label>
                                                        <div style="margin-left: 25px; margin-right: 20px;">
                                                            <p>
                                                                @php
                                                                    echo $item->description;
                                                                @endphp
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ $data['currency_data']->symbol }} {{ $item->rate }} </p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ $item->qty }} {{ $item->qty_name }}</p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext" style="margin-right: 10px;">{{ $data['currency_data']->symbol }} {{ $item->price }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="tabletitle">
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td>
                                                <td class="tableitem">
                                                    <h2>Sub Total</h2>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext"></p>
                                                </td>
                                                <td class="tableitem"><h6 style="margin-right: 10px;">{{ $data['currency_data']->symbol }} {{ $data['price']}}</h6></td>
                                            </tr>
                                            @if($data['discount']>0)
                                                <tr class="service1">
                                                    <td class="tableitem"></td>
                                                    <td class="tableitem"></td>
                                                    <td class="tableitem">
                                                        <h2>Discount {{ $data['discount'] }}(%)</h2>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext"></p>
                                                    </td>
                                                    <td class="tableitem"><h6 style="margin-right: 10px;">{{ $data['currency_data']->symbol }} {{ $data['discount_amount']}}</h6></td>
                                                </tr>
                                            @endif
                                            @if($data['gst_per']>0)
                                                @if($data['igst']==1)
                                                    <tr class="service1">
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem">
                                                            <h2>IGST {{ $data['gst_per'] }}(%)</h2>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext"></p>
                                                        </td>
                                                        <td class="tableitem"><h6 style="margin-right: 10px;">{{ $data['currency_data']->symbol }} {{ $data['gst_amount']}}</h6></td>
                                                    </tr>
                                                @else
                                                    <tr class="service1">
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem">
                                                            <h2>CGST {{ $data['gst_per']/2 }}(%)</h2>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext"></p>
                                                        </td>
                                                        <td class="tableitem"><h6 style="margin-right: 10px;">{{ $data['currency_data']->symbol }} {{ $data['gst_amount']/2}}</h6></td>
                                                    </tr>
                                                    <tr class="service1">
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem">
                                                            <h2>SGST {{ $data['gst_per']/2 }}(%)</h2>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext"></p>
                                                        </td>
                                                        <td class="tableitem"><h6 style="margin-right: 10px;">{{ $data['currency_data']->symbol }} {{ $data['gst_amount']/2}}</h6></td>
                                                    </tr>
                                                @endif
                                            @endif
                                            <tr class="tabletitle">
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td>
                                                <td class="tableitem">
                                                    <h2>Total Amount</h2>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext"></p>
                                                </td>
                                                <td class="tableitem"><h6 style="margin-right: 10px;">{{ $data['currency_data']->symbol }} {{ $data['total_amount'] }}</h6></td>
                                            </tr>
                                            <tr>
                                                <td class="tableitem" style="text-align: left;" colspan="5"><b>Amount In words : {{ $data['amount_word'] }} </b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!--End Table-->


                                <div id="legalcopy">
                                    <p class="legal"><strong><b>{{  $data['company_data']->technology_label ?? 'Technology' }}</b></strong></p>
                                    <div class="legal1">
                                        @php
                                            if($data['technology']!='')
                                            {
                                                echo $data['technology'];
                                            }
                                            else
                                            {
                                                echo $data['company_data']->technology;
                                            }
                                        @endphp
                                    </div>
                                </div>

                                <div id="legalcopy">
                                    <p class="legal"><strong><b>{{  $data['company_data']->milestone_label ?? 'Mile Stone' }}</b></strong></p>
                                    <div class="legal1">
                                        @php
                                            if($data['milestone']!='')
                                            {
                                                echo $data['milestone'];
                                            }
                                            else
                                            {
                                                echo $data['company_data']->milestone;
                                            }
                                        @endphp
                                    </div>
                                </div>

                                @php
                                    if($data['working_days']>0)
                                    {
                                        @endphp
                                        <div id="legalcopy">
                                            <p class="legal"><strong><b>Total Working Days : </b></strong></p>
                                            <p class="legal1">{{ $data['working_days']}} Working Days</p>
                                        </div>
                                        @php
                                    }
                                @endphp

                                @php
                                    if($data['payment_terms_conditions_flag']==1)
                                    {
                                        @endphp
                                        <div id="legalcopy">
                                            <p class="legal"><strong><b>Payment Terms And Conditions :</b></strong></p>
                                            <div class="legal1">
                                                @php
                                                    if($data['payment_terms_conditions']!='')
                                                    {
                                                        echo $data['payment_terms_conditions'];
                                                    }
                                                    else
                                                    {
                                                        echo $data['company_data']->payment_terms_conditions;
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                        @php
                                    }
                                @endphp

                                @php
                                    if($data['terms_conditions_flag']==1)
                                    {
                                        @endphp
                                        <div id="legalcopy">
                                            <p class="legal"><strong><b>Terms And Conditions :</b></strong></p>
                                            <div class="legal1">
                                                @php
                                                    if($data['terms_conditions']!='')
                                                    {
                                                        echo $data['terms_conditions'];
                                                    }
                                                    else
                                                    {
                                                        echo $data['company_data']->terms_conditions;
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                        @php
                                    }
                                @endphp

                                @php
                                    if($data['bank_details_flag']==1)
                                    {
                                        @endphp
                                        <div id="legalcopy">
                                            <p class="legal"><strong><b>Payment Details are as mentioned below :</b></strong></p>
                                            <div class="legal1">
                                                @php
                                                    if($data['bank_details']!='')
                                                    {
                                                        echo $data['bank_details'];
                                                    }
                                                    else
                                                    {
                                                        echo $data['company_data']->bank_details;
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                        @php
                                    }
                                @endphp
                            </div>
                            <!--End InvoiceBot-->
                        </div>
                        <!--End Invoice-->
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal" class="Modal is-hidden is-visuallyHidden"  tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog">
            <div class="modal-dialog" style="max-width: 400px !important;">
                <div class="modal-content">
                    <div class="modal-body" align="center">
                        <div class="loader" id="loader">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        var invoice_no= "{{ $data['invoice_no'] }}";

        window.onload = function ()
        {
            $("#pdfdownload").click(function()
            {
                $("#myModal").show(0).delay(5500).hide(0);
                $("#pdfdownload").text('');
                printpdf();
                $("#pdfdownload").text('Generate PDF');
            });
        }

        function printpdf()
        {
            var element = document.getElementById("unix-invoice");
            var opt = {
                margin:       [30, 0, 15, 0],
                pagebreak: { mode: ['css', 'A4'], after:'.break-page' },
                filename:     invoice_no+'.pdf',
                image:        { type: 'jpeg', quality: 1 },
                html2canvas:  { dpi: 192, scale: 2, useCORS: true, letterRendering: true },
                jsPDF:        { unit: 'pt', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().from(element).set(opt).save();
        }
    </script>
@endsection
