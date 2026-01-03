@extends('layouts.Admin.invoice_app')

@section('content')
    <div class="unix-invoice">
        <div class="container-fluid">
            <div class="row">
                <button id="pdfdownload" class="btn btn-primary">Generate PDF</button>
                <div class="col-lg-12">
                    <div id="invoice" class="effect2 m-t-80">
                        <div id="invoice-top">
                            <div class="invoice-logo">
                                <img  id="invoice-logo" src="{{ asset('asset/images/invoice-logo.png') }}" alt=""/>
                            </div>
                            <!--End Info-->
                            <div class="title">
                                <h5>Quotation : {{ $data['invoice_no'] }}</h5>
                                <p>Issued : {{ $data['entrydate'] }}<br>Open Till : {{ $data['open_date'] }}
                                </p>
                            </div>
                            <!--End Title-->
                        </div>
                        <!--End InvoiceTop-->



                        <div id="invoice-mid">
                            <div class="invoice-info">
                                <h2>TechMayntra Service PVT LTD</h2>
                                <p>915, J B Tower, Opp Doordarshan kendra,Thaltej,<br> Ahmedabad,Gujarat</p>
                            </div>
                            <div class="invoice-client">
                                <h2>{{ $data['customer_company_name'] }}</h2>
                                <p>{{ $data['address'] }}<br> {{ $data['city'] }}, {{ $data['state'] }}<br></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="invoice-info">
                                <h2>Quotation - {{ $data['title'] }} </h2>
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
                                                <h2>Item</h2>
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
                                        @foreach($data['item_data'] as $item )
                                            <tr class="service1">
                                                <td class="tableitem">
                                                    {{ $i++ }}
                                                </td>
                                                <td class="tableitem">
                                                    <h6> {{ $item->item_name }}</h6>
                                                    <div style="margin-left: 25px;">
                                                        @php
                                                            echo $item->description;
                                                        @endphp
                                                    </div>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">₹ {{ $item->rate }}</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">₹ {{ $item->qty }}</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">₹ {{ $item->price }}</p>
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
                                            <td class="tableitem"><h6>₹ {{ $data['price']}}</h6></td>
                                        </tr>
                                        <tr class="service1">
                                            <td class="tableitem"></td>
                                            <td class="tableitem"></td>
                                            <td class="tableitem">
                                                <h2>Discount {{ $data['discount'] }}(%)</h2>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext"></p>
                                            </td>
                                            <td class="tableitem"><h6>₹ {{ $data['discount_amount']}}</h6></td>
                                        </tr>
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
                                                <td class="tableitem"><h6>₹ {{ $data['gst_amount']}}</h6></td>
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
                                                <td class="tableitem"><h6>₹ {{ $data['gst_amount']/2}}</h6></td>
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
                                                <td class="tableitem"><h6>₹ {{ $data['gst_amount']/2}}</h6></td>
                                            </tr>
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
                                            <td class="tableitem"><h6>₹ {{ $data['total_amount']}}</h6></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!--End Table-->


                            <!-- <div id="legalcopy">
                                <p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices.
                                </p>
                            </div> -->

                        </div>
                        <!--End InvoiceBot-->
                    </div>
                    <!--End Invoice-->
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    <script>
        var invoice_no= "{{ $data['invoice_no'] }}";
        
        $("#pdfdownload").click(function()
        {
            $("#pdfdownload").text('');
            var pdfdoc = new jsPDF('p', 'pt', 'a4', true);
            var specialElementHandlers = {
                "#ignoreElement": function (element, renderer)
                {
                    return true;
                }
            };
            // $("#invoice-bot").css('width','5%!important');
            pdfdoc.fromHTML($("html").get(0), 20, 20,
                {
                    'width': '100%',
                    'elementHandlers': specialElementHandlers
                },
                function(bla)
                {
                    // pdfdoc.save(invoice_no+'.pdf');
                    pdfdoc.output("dataurlnewwindow");
                }
            );
            // $("#invoice-bot").css('width','100%!important');
            $("#pdfdownload").text('Generate PDF');
        });
    </script>
@endsection