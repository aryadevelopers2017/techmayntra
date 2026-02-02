<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 230px 30px 140px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        /* HEADER */
        header {
            position: fixed;
            top: -230px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }

        header img {
            width: 100%;
        }

        /* FOOTER */
        footer {
            position: fixed;
            bottom: -120px;
            left: 0;
            right: 0;
            height: 110px;
            text-align: center;
            font-size: 11px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .page-number:before {
            content: "Page " counter(page);
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
            text-align: center;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .no-border td { border: none; }

        .section-title {
            margin-top: 10px;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }


        #invoice-logo{
            margin-top:17px;
        }

    </style>
</head>

<body>
    {{-- HEADER --}}
    <header style="margin-bottom:100px;">
        <img src="{{ public_path('asset/images/leterhead-header.jpg') }}" >
    </header>
    {{-- FOOTER --}}
    <footer>
        <div>Office # 301-09 Riser Business Center, Rigga Business Center Building</div>
        <div>IBIS Hotel, Al Rigga, Deira, Dubai - UAE</div>
        <div>
            Mob: +971 55 556 6410 |
            Email: info@tripmantra.ae |
            Web: www.tripmantra.ae
        </div>
        <div class="page-number"></div>
    </footer>
    <main>
        {{-- INVOICE HEADER --}}
        <table width="100%" style=" border-collapse: collapse;">
            <tr>
                {{-- LEFT SIDE --}}
                <td width="65%" style="vertical-align: top;">
                    <table class="no-border" width="100%" style=" border-collapse: collapse;">
                        <tr>
                            <td width="40%" >
                                <img
                                    src="{{ public_path('asset/images/'.$data['company_data']->company_logo) }}"
                                    style="height: 130px; "
                                    alt="Company Logo"
                                    >
                            </td>
                            <td>
                                <div>
                                    <strong>{{ strtoupper($data['company_data']->company_name) }}</strong><br>
                                    {!! $data['company_address'] !!}<br>
                                    {{ $data['company_city'] }}, {{ $data['company_state'] }}<br>
                                    @if(!empty($data['company_data']->trn_no))
                                    <strong>TRN:</strong> {{ $data['company_data']->trn_no }}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                {{-- RIGHT SIDE --}}
                <td width="35%" style="vertical-align: top; text-align: justify;">
                    <strong>Invoice No:</strong> {{ $data['invoice_no'] }}<br>
                    <strong>Date:</strong> {{ $data['entrydate'] }}
                    <br>
                    <strong>Buyer (Bill To)</strong><br>
                    {{ $data['customer_company_name'] }}<br>
                    {{ strip_tags($data['address']) }}<br>
                    {{ $data['city'] }}, {{ $data['state'] }}<br>
                    {{ $data['gst_no'] }}
                </td>
            </tr>
        </table>
        <br>
        <h3 class="text-center">TAX INVOICE</h3>
         <p><b>Title</b> - {{ $data['title'] }} </p>
        {{-- ITEMS TABLE --}}
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description of Services</th>
                    <th>HSN</th>
                    <th>Rate</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($data['item_data'] as $item)
                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td class="text-center">998313</td>
                    <td class="text-right">{{ $data['currency_data']->symbol }} {{ number_format($item->net_rate, 2) }}</td>
                    <td class="text-center">{{ $item->qty }} {{ $item->qty_name }}</td>
                    <td class="text-right">{{ $data['currency_data']->symbol }} {{ number_format($item->net_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- TOTALS --}}
        <table>
            <tr>
                <td colspan="5" class="text-right"><strong>Sub Total</strong></td>
                <td class="text-right">{{ $data['currency_data']->symbol }} {{ $data['taxable_amount'] }}</td>
            </tr>
            @if($data['gst_per']>0)

                @if($data['igst']==1)
                    <tr>
                        <td colspan="5" class="text-right">
                            <strong>IGST {{ $data['gst_per'] }}(%)</strong>
                        </td>
                        <td class="text-right">{{ $data['currency_data']->symbol }} {{ $data['gst_amount']}} </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5" class="text-right">
                            <strong>CGST ({{ $data['gst_per']/2 }}(%))</strong>
                        </td>
                        <td class="text-right">{{ $data['currency_data']->symbol }} {{ $data['gst_amount']/2}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <strong>SGST ({{ $data['gst_per']/2 }}(%))</strong>
                        </td>
                        <td class="text-right">{{ $data['currency_data']->symbol }} {{ $data['gst_amount']/2}}</td>
                    </tr>
                @endif
            @endif
            <tr>
                <td colspan="5" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>{{ $data['currency_data']->symbol }} {{ $data['total_amount'] }}</strong></td>
            </tr>
        </table>
        <p><strong>Amount in words:</strong> {{ $data['amount_word'] }}</p>
        {{-- BANK DETAILS --}}

        <div id="legalcopy">
            <p class="legal"><strong><b>Payment Details are as mentioned below :</b></strong></p>
            <div class="row">
                <div class="col-md-6">
                     @if(!empty($data['bank_details']))
                            {!! $data['bank_details'] !!}
                        @else
                            {!! $data['company_data']->bank_details !!}
                        @endif
                </div>

            </div>
        </div>



        <div class="legalcopy" style="text-align: right;">

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


<div style="page-break-before: always;"></div>


        <div id="legalcopy">
            <p class="legal"><strong><b> {{  $data['company_data']->technology_label ?? 'Technology' }}  :</b></strong></p>
            <div class="row">
                <div class="col-md-6">

                        @if(!empty($data['original_quotation_data']->technology))
                            {!! $data['original_quotation_data']->technology !!}
                        @else
                            {!! $data['company_data']->technology !!}
                        @endif
                </div>

            </div>
        </div>

<div style="page-break-before: always;"></div>

        <div id="legalcopy">
            <p class="legal"><strong><b>{{  $data['company_data']->milestone_label ?? 'Mile Stone' }} :</b></strong></p>
            <div class="row">
                <div class="col-md-6">

                           @if(!empty($data['original_quotation_data']->milestone))
                            {!! $data['original_quotation_data']->milestone !!}
                        @else
                            {!! $data['company_data']->milestone !!}
                        @endif
                </div>

            </div>
        </div>


      @if(isset($data['original_quotation_data']) && $data['original_quotation_data']->terms_conditions_flag == 1)
      <div style="page-break-before: always;"></div>

        <div id="legalcopy">
            <p class="legal"><strong><b>Terms & Conditions :</b></strong></p>

            <div class="row">
                <div class="col-md-6">
                    @if(!empty($data['original_quotation_data']->terms_conditions))
                        {!! $data['original_quotation_data']->terms_conditions !!}
                    @else
                        {!! $data['company_data']->terms_conditions !!}
                    @endif
                </div>
            </div>
        </div>
    @endif


     @if(isset($data['original_quotation_data']) && $data['original_quotation_data']->payment_terms_conditions_flag == 1)
     <div style="page-break-before: always;"></div>

        <div id="legalcopy">
            <p class="legal"><strong><b>Payment terms & Conditions :</b></strong></p>

            <div class="row">
                <div class="col-md-6">
                    @if(!empty($data['original_quotation_data']->payment_terms_conditions))
                        {!! $data['original_quotation_data']->payment_terms_conditions !!}
                    @else
                        {!! $data['company_data']->payment_terms_conditions !!}
                    @endif
                </div>
            </div>
        </div>
    @endif



    </main>
</body>
</html>
