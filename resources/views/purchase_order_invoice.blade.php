@extends('layouts.Admin.invoice_app')

@section('content')
    <div class="row">
        <div class="col-md-6" style="text-align: right;">
            <button id="pdfdownload" class="btn btn-primary">Generate PDF</button>
        </div>
    </div>
    <div id="app">
        <div class="unix-invoice" id="unix-invoice">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div id="invoice" class="effect2 m-t-10" style="border: 2px solid #000000;">
                            <div id="invoice-top">
                                <div class="invoice-logo">
                                    <img  id="invoice-logo" src="{{ asset('asset/images/'.$data['company_data']->company_logo) }}" height="50px" alt=""/>
                                </div>
                                <!--End Info-->
                                <div class="title">
                                    <h5>Order No : {{ $data->order_no }}</h5>
                                    <p>Date : {{ $data->purchase_date }}
                                    </p>
                                </div>
                                <!--End Title-->
                            </div>
                            <!--End InvoiceTop-->

                            <div class="row">
                                <div class="col-md-6" style="text-align: left;">
                                    <h2 style="font-size: 14px;">{{ $data['company_data']->company_name }}</h2>
                                    {{ $data['company_data']->address }}
                                    <p>{{ $data['company_data']->city.','. $data['company_data']->state }}
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <h2 style="font-size: 14px;">Buyer (Bill to) </h2><h2 style="font-size: 14px;"> {{ $data->company_name }}</h2>
                                    <p>{{ strip_tags($data['address']) }}<br> {{ $data['city'] }}, {{ $data['state'] }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;">
                                    <h4>Purchase Order</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Title</b> - {{ $data->subject }} </p>
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
                                                    <h2>QTY</h2>
                                                </td>
                                                <td class="subtotal">
                                                    <h2>Amount</h2>
                                                </td>
                                            </tr>
                                            @php
                                                $i=1;
                                            @endphp
                                            <tr class="service1">
                                                <td class="tableitem">
                                                    {{ $i++ }}
                                                </td>
                                                <td class="tableitem" style="text-align: center;">
                                                    <h6> {{ $data->product_name }}</h6>
                                                    <div style="margin-left: 25px;">
                                                        {{ $data->description }}
                                                    </div>
                                                </td>
                                                <td class="tableitem">
                                                    998313
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">₹ @php echo ROUND( $data->amount,2); @endphp </p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">1</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">₹ @php echo ROUND($data->amount,2); @endphp</p>
                                                </td>
                                            </tr>
                                            <tr class="tabletitle">
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td> 
                                                <td class="tableitem"></td>
                                                <td class="tableitem">
                                                    <h2>Sub Total</h2>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext"></p>
                                                </td>
                                                <td class="tableitem"><h6>₹ {{ $data->amount}}</h6></td>
                                            </tr>
                                            @if($data['gst']==1)
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
                                                        <td class="tableitem"><h6>₹ {{ $data['gst_amount']}}</h6></td>
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
                                                        <td class="tableitem"><h6>₹ {{ $data['gst_amount']/2}}</h6></td>
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
                                                        <td class="tableitem"><h6>₹ {{ $data['gst_amount']/2}}</h6></td>
                                                    </tr>
                                                @endif
                                            @endif
                                            <tr class="tabletitle">
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td>
                                                <td class="tableitem"></td>
                                                <td class="tableitem">
                                                    <h2>Total Amount</h2>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext"></p>
                                                </td>
                                                <td class="tableitem"><h6>₹ {{ $data['total_amount']}}</h6></td>
                                            </tr>
                                            <tr>
                                                <td class="tableitem" style="text-align: left;" colspan="5"><b>Amount In words :  {{ $data['amount_word'] }}</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!--End Table-->
                                <div id="legalcopy">
                                    
                                </div>
                                <div id="invoice-top1">
                                    <div class="col-md-9 invoice-logo mt-3">
                                        <p><b>Declaration</b></p>
                                        <br>
                                        <p style="margin-left: 10px;">We declare that this invoice shows the actual price of the goods/services described and that all particulars are true and correct.</p>
                                    </div>
                                    <!--End Info-->
                                    <div class="col-md-3 title mt-3">
                                        <p><b>For,  {{ $data['company_data']->company_name }}</b></p>
                                        <br>
                                        <p style="text-align: right;">Authorised Signatory </p>
                                    </div>
                                    <!--End Title-->
                                </div>
                            </div>
                            <!--End InvoiceBot-->
                            <!-- <div class="pt-1" style="border-top: 1px solid #000000;">
                                <div class="text-center">
                                    <p style="margin-left: 25px;">Option 1: Online Transfer. Option 2: Cheque on the name of {{ $data['company_data']->company_name }}</p>
                                </div>
                                <div class="text-center mt-3">
                                    <h5>SUBJECT TO AHMEDABAD JURISDICTION</h5>
                                    <p>This is a Computer Generated Invoice</p>
                                </div>
                            </div> -->
                        </div>
                        <!--End Invoice-->
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
                $("#pdfdownload").text('');
                printpdf(); 
                $("#pdfdownload").text('Generate PDF');
            });   
        }

        function printpdf()
        {
            var element = document.getElementById("unix-invoice");
            
            var opt = {
                margin:       [30, 0, 30, 0],
                pagebreak: { mode: ['avoid-all', 'css', 'A4'], after:'.break-page' },
                filename:     invoice_no+'.pdf',
                image:        { type: 'png', quality: 1 },
                html2canvas:  { dpi: 192, scale: 2, letterRendering: true },
                jsPDF:        { unit: 'pt', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().from(element).set(opt).save();
        }
    </script>
@endsection