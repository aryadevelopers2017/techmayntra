<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans|Rock+Salt|Shadows+Into+Light|Cedarville+Cursive');
    .modal-backdrop
    {
        background-color: rgba(0, 0, 0, 0.4) !important;;
        -webkit-transition: 0.5s;
        overflow: auto;
        transition: all 0.3s linear;
    }
    body
    {
        /* margin: 10px !important; */
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

    table { page-break-inside:auto }
    tr    { page-break-inside:auto; page-break-after:auto }
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

    #invoice-logo{
        height: auto;
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
                        <div id="invoice" class="effect2 " >
                             <img src="{{ asset('asset/images/leterhead-header.jpg') }}" style="width: 100%;">

                            <div id="invoice-top">
                                <div class="invoice-logo">
                                    <img  id="invoice-logo" src="{{ asset('asset/images/'.$data['company_data']->company_logo) }}" height="50px" alt=""/>
                                </div>
                                <!--End Info-->
                                <div class="title">
                                    <h5>Invoice No : {{ $data['invoice_no'] }}</h5>
                                    <p>Date : {{ $data['entrydate'] }}
                                    </p>
                                </div>
                                <!--End Title-->
                            </div>
                            <!--End InvoiceTop-->

                            <div class="row">
                                <div class="col-md-6" style="text-align: left;">
                                    <h2 style="font-size: 14px;">{{ strtoupper($data['company_data']->company_name) }}</h2>
                                    @php echo $data['company_address']; @endphp
                                    <p>{{ $data['company_city'].','. $data['company_state'] }}<br>

                                    <!-- <strong>GST No : {{ $data['company_data']->gst_no }}</strong><br>
                                    <strong>Pan No : {{ $data['company_data']->pan_no }}</strong> -->


                                    @if(!empty($data['company_data']->trn_no))
                                        <strong>Trn No : {{ $data['company_data']->trn_no }}</strong>
                                    @endif


                                </p>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <h2 style="font-size: 14px;">Buyer (Bill to) </h2>
                                    <h2 style="font-size: 14px;"> {{ $data['customer_company_name'] }}</h2>
                                    <p>{{ strip_tags($data['address']) }}<br> {{ $data['city'] }}, {{ $data['state'] }}
                                    <br>{{ $data['gst_no'] }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;">
                                    <h4>Tax Invoice</h4>
                                </div>
                            </div>
                            <!--End Invoice Mid-->
                            <div id="invoice-bot">
                                <div id="invoice-table">
                                    <div class="table-responsive">
                                        <table class="table" style="width: 99%!important;border: 1px solid #000000;">
                                            <tr class="tabletitle1">
                                                <td class="Hours">
                                                    <h2>#</h2>
                                                </td>
                                                <td class="table-item" style="text-align: center;">
                                                    <h2>Description of Services</h2>
                                                </td>
                                                <td class="Rate">
                                                    <h2>HSN Code</h2>
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
                                                    <td class="tableitem" style="text-align: center;">
                                                        <label class="m-t-3" style="font-weight: 500;margin-bottom: 0px!important;"><h6>{{ $item->item_name }}</h6></label>
                                                        <!-- <div style="margin-left: 25px;">
                                                            <p class="text-justify">
                                                                @php
                                                                    echo $item->description;
                                                                @endphp
                                                            </p>
                                                        </div> -->
                                                    </td>
                                                    <td class="tableitem">
                                                        998313
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">₹ @php echo ROUND( $item->net_rate,2); @endphp </p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ $item->qty }} {{ $item->qty_name }}</p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext" style="margin-right: 10px;">₹ @php echo ROUND($item->net_price,2); @endphp</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                            <tr class="tabletitle" style="border: 1px solid;">
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td>
                                                <td class="tableitem">
                                                    <h2>Sub Total</h2>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext"></p>
                                                </td>
                                                <td class="tableitem"><h6 style="margin-right: 10px;">₹ {{ $data['taxable_amount']}}</h6></td>
                                            </tr>



                                            @if($data['gst_per']>0)
                                                @if($data['igst']==1)
                                                    <tr class="service1">
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem">
                                                            <h2>IGST {{ $data['gst_per'] }}(%)</h2>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext"></p>
                                                        </td>
                                                        <td class="tableitem"><h6 style="margin-right: 10px;">₹ {{ $data['gst_amount']}}</h6></td>
                                                    </tr>
                                                @elseif($data['original_quotation_data']->vat==1)
                                                            <tr>
                                                                <td colspan="5" class="text-right">
                                                                    <strong>VAT {{ $data['gst_per'] }}(%)</strong>
                                                                </td>
                                                                <td class="text-right">{{ $data['currency_data']->symbol }} {{ $data['gst_amount']}} </td>
                                                            </tr>

                                                @else
                                                    <tr class="service1">
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem">
                                                            <h2>CGST {{ $data['gst_per']/2 }}(%)</h2>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext"></p>
                                                        </td>
                                                        <td class="tableitem"><h6 style="margin-right: 10px;">₹ {{ $data['gst_amount']/2}}</h6></td>
                                                    </tr>
                                                    <tr class="service1">
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem"></td>
                                                        <td class="tableitem">
                                                            <h2>SGST {{ $data['gst_per']/2 }}(%)</h2>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext"></p>
                                                        </td>
                                                        <td class="tableitem"><h6 style="margin-right: 10px;">₹ {{ $data['gst_amount']/2}}</h6></td>
                                                    </tr>
                                                @endif
                                            @endif
                                            <tr class="tabletitle" style="border: 1px solid;">
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td>
                                                <td class="tableitem">
                                                    <h2>Total Amount</h2>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext"></p>
                                                </td>
                                                <td class="tableitem"><h6 style="margin-right: 10px;">₹ {{ $data['total_amount']}}</h6></td>
                                            </tr>
                                            <tr>
                                                <td class="tableitem" style="text-align: left;" colspan="5"><b>Amount In words :  {{ $data['amount_word'] }}</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!--End Table-->
                                <div id="legalcopy">
                                    <p class="legal"><strong><b>Payment Details are as mentioned below :</b></strong></p>
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <!-- <div class="col-md-6">
                                            <p style="text-align: right;"><b>For,  {{ $data['company_data']->company_name }}</b></p>
                                            <p style="text-align: right;"><b>Authorised Signatory <b></p>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="legalcopy" style="text-align: right;">

                                    <!-- <img  id="invoice-logo" src="{{ asset('asset/images/'.$data['company_data']->company_logo) }}" height="50px" alt=""/> -->

                                        <img
                                            src="{{ asset('asset/images/paid.webp') }}"
                                            alt="PAID"
                                            style="
                                                width: 140px;

                                                top: -90px;
                                                right: 20px;

                                            "
                                        >

                                    <p style="font-family: 'Shadows Into Light', cursive; font-style: oblique; font-stretch: ultra-condensed; font-size: 22px;margin-right: 25px;"><i>Subhash</i></p>
                                    <p style="text-align: right;"><b>Authorised Signatory <b></p>
                                    <p style="text-align: right;"><b>For,  {{ $data['company_data']->company_name }}</b></p>
                                </div>
                                <div class="legalcopy">
                                    <p><b>Declaration</b></p>
                                    <p style="margin-left: 10px;font-weight: 400;">We declare that this invoice shows the actual price of the goods/services described and that all particulars are true and correct.</p>
                                    <!--End Info-->
                                    <!--End Title-->
                                </div>
                            </div>
                            <!--End InvoiceBot-->
                        </div>
                        <div class="pt-1" id="legalcopy" style="font-size: 14px;">
                            <div class="text-center" style="margin-left: 25px;font-weight:400;">
                                <p>Option 1: Online Transfer. Option 2: Cheque on the name of {{ $data['company_data']->company_name }}</p>
                                <p>SUBJECT TO AHMEDABAD JURISDICTION</p>
                                <p>This is a Computer Generated Invoice</p>
                            </div>
                        </div>


                          <div style="

                                        text-align: center;
                                        font-size: 15px;
                                        border-top: 1px solid #000;
                                        padding-top: 6px;
                                    ">

                                        <div>
                                            Office # 301-09 Riser Business Center, Rigga Business Center Building,
                                        </div>
                                        <div>
                                            IBIS Hotel, Al Rigga, Deira, Dubai - UAE
                                        </div>
                                        <div>
                                            Mob: +971 55 556 6410 |
                                            Email: info@tripmantra.ae |
                                            Web: www.tripmantra.ae
                                        </div>
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
                margin:       [0, 0, 0, 0],
                pagebreak: { mode: ['css', 'A4'], after:'.break-page', avoid: ['tr', 'td'] },
                filename:     invoice_no+'.pdf',
                image:        { type: 'png', quality: 1 },
                html2canvas:  { dpi: 192, scale: 2, useCORS: true, letterRendering: true },
                jsPDF:        { unit: 'pt', format: 'a4', orientation: 'portrait', compress: true }
            };

            html2pdf().from(element).set(opt).save();
        }
    </script>
@endsection
