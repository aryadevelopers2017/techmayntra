<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
             margin: 140px 30px 80px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        /* HEADER */
        header {
            position: fixed;
            top: -130px;
            left: 0;
            right: 0;
            height: 120px;
        }

        header img {
            width: 100%;
        }

        /* FOOTER */
        footer {
            position: fixed;
            bottom: -150px;
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
            background: #72cac5;
            text-align: center;
            color: #000000;;
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
    <header >
        <!-- <img src="{{ public_path('asset/images/leterhead-header.jpg') }}" > -->


        <table width="100%" class="no-border" style="margin-top: 25px;">
            <tr>

                <td width="65%" style="vertical-align: top;">
                    <table class="no-border" width="100%" >
                        <tr>
                            <td >
                                <img
                                    src="{{ public_path('asset/images/'.$data['company_data']->company_logo) }}"
                                    style="height: 85px;width:auto; "
                                    alt="Company Logo"
                                    >
                            </td>
                        </tr>
                    </table>
                </td>

                <td width="35%" style="vertical-align: end; text-align: right;">
                    <strong style="font-size:22px;">Invoice</strong> <br>
                        <span> #{{ $data['invoice_no'] }}</span>

                </td>
            </tr>
        </table>

    </header>
    {{-- FOOTER --}}
  <footer>
    <table width="100%" style="border: none; font-size: 11px;">
        <tr>
            <td style="text-align:left; border:none; width: 30%;">
                {{ $data['company_data']->mobile ?? '' }}
            </td>

            <td style="text-align:center; border:none; width: 30%;">
                {{ $data['company_data']->email ?? '' }}
            </td>

            <td style="text-align:right; border:none; width: 30%;">
                {{ $data['company_data']->website ?? '' }}
            </td>
        </tr>
    </table>
</footer>


    <main>

{{-- INVOICE HEADER BOXES --}}
<table width="100%" cellspacing="0" class="no-border" cellpadding="0" style="border-collapse:collapse; margin-top:10px;">
    <tr>

        {{-- BILL TO BOX --}}
        <td width="50%" style="vertical-align:top; padding-right:10px;">
            <table width="100%" cellspacing="0" class="no-border" cellpadding="0" style="border:1px solid #000; border-collapse:collapse;">

                <tr>
                    <td style="background:#72cac5;color:#000000; padding:6px; font-weight:bold; text-align:center; border-bottom:1px solid #000;">
                        Invoice To
                    </td>
                </tr>

                <tr>
                    <td style="padding:0; border:0;">
                        <div style="height:110px; padding:8px; font-size:12px; line-height:18px;">
                            <strong>{{ $data['customer_name'] }}</strong><br>


{{ $data['customer_company_name'] }}<br>

                            {{ strip_tags($data['address']) }}
@if(!empty($data['city']))
    , {{ $data['city'] }}
@endif
@if(!empty($data['state']))
    , {{ $data['state'] }}
@endif
 <br>

{{ $data['email'] }}<br>

{{ $data['mobile'] }}<br>


                            {{ $data['gst_no'] }}
                        </div>
                    </td>
                </tr>

            </table>
        </td>

        {{-- COMPANY BOX --}}
        <td width="50%" style="vertical-align:top; padding-left:10px;">
            <table width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #000; border-collapse:collapse;">

                <tr>
                    <td style="background:#72cac5;color:#000000; padding:6px; font-weight:bold; text-align:center; border-bottom:1px solid #000;">
                        Company Info
                    </td>
                </tr>

                <tr>
                    <td style="padding:0; border:0;">
                        <div style="height:110px; padding:8px; font-size:12px; line-height:18px;">
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

    </tr>
</table>





        <!-- <br>
        <h3 class="text-center">TAX INVOICE</h3>
         <p><b>Title</b> - {{ $data['title'] }} </p> -->


         {{-- INVOICE INFO HEADER TABLE --}}
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse; margin-bottom: 10px; margin-top: 20px;">

    <tr style="background:#72cac5; color: #000000;">
        <td style="border:1px solid #000; padding:6px; font-weight:bold; text-align:center;">
            Title
        </td>
        <td style="border:1px solid #000; padding:6px; font-weight:bold; text-align:center;">
            Invoice Date
        </td>
        <td style="border:1px solid #000; padding:6px; font-weight:bold; text-align:center;">
            Due Date
        </td>

         <td style="border:1px solid #000; padding:6px; font-weight:bold; text-align:center;">
            Agent Name
        </td>
    </tr>

    <tr>
        <td style="border:1px solid #000; padding:6px; text-align:center;">
            {{ $data['title'] }}
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:center;">
            {{ $data['entrydate'] }}
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:center;">
            {{ $data['due_date'] }}
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:center;">
            {{ $data['AssignedStaffName'] }}
        </td>
    </tr>

</table>




        {{-- ITEMS TABLE --}}
        <table>
            <thead>
                <tr>
                    <th>#</th>

                    <th>Description</th>

                    <th>{{ $data['currency_data']->symbol }} Price</th>


  <th> Qty / Unit </th>
                    <th> {{ $data['currency_data']->symbol }} Amount</th>

                    <th>Vat</th>

                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($data['quotation_item_data'] as $item)

                @php
    $qty = $item->qty;
    $totalWithVat =  number_format($item->net_rate, 2)  * $qty;  // VAT already included



    $vatPercent = $item->taxvalue ?? 0;

    $vatAmount = ($totalWithVat * $vatPercent) / (100 + $vatPercent);

    $amountWithoutVat = $totalWithVat - $vatAmount;

$rowprice = $amountWithoutVat / $qty ;

@endphp


                <tr>
                    <td class="text-center">{{ $i++ }}</td>

                    <td style="width: 22%;">{{ $item->item->item_name }}</td>

                    <td class="text-right">{{ number_format($rowprice, 2) }}</td>

                    <td class="text-center">{{ $item->qty }} {{ $item->qty_name }}</td>



                        {{-- Amount without VAT --}}
                        <td class="text-right">{{ number_format($amountWithoutVat, 2) }}</td>

                        {{-- VAT extracted --}}
                        <td class="text-right">{{ number_format($vatAmount, 2) }}</td>

                        {{-- Total with VAT (original) --}}
                        <td class="text-right">
                            {{ $data['currency_data']->symbol }} {{ number_format($totalWithVat, 2) }}
                        </td>


                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- TOTALS --}}

       @php
    $subTotal = 0;
    $totalVat = 0;

    foreach($data['quotation_item_data'] as $item) {

        $qty = $item->qty;
        $priceWithVat = $item->net_rate; // same as table

        $totalWithVat = $priceWithVat * $qty;

        $vatPercent = $item->taxvalue ?? 0;
        $vatAmount = ($totalWithVat * $vatPercent) / (100 + $vatPercent);

        $amountWithoutVat = $totalWithVat - $vatAmount;

        $subTotal += $amountWithoutVat;
        $totalVat += $vatAmount;
    }

    $grandTotal = $subTotal + $totalVat;
@endphp



      <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:10px;">
    <tr>
        <td style="width:70%; text-align:right; padding:6px;">
            <strong>Sub Total</strong>
        </td>

        <td style="width:30%; text-align:right; padding:6px;">
            {{ $data['currency_data']->symbol }} {{ number_format($subTotal, 2) }}
        </td>
    </tr>

    <tr>
        <td style="width:70%; text-align:right; padding:6px;">
            <strong>Total VAT</strong>
        </td>

        <td style="width:30%; text-align:right; padding:6px;">
            {{ $data['currency_data']->symbol }} {{ number_format($totalVat, 2) }}
        </td>
    </tr>

    <tr>
        <td style="width:70%; text-align:right; padding:6px;">
            <strong>Total</strong>
        </td>

        <td style="width:30%; text-align:right; padding:6px;">
            <strong>{{ $data['currency_data']->symbol }} {{ number_format($grandTotal, 2) }}</strong>
        </td>
    </tr>
</table>


        <p><strong>Amount in words:</strong> {{ $data['amount_word'] }}</p>
        {{-- BANK DETAILS --}}

        <div id="legalcopy">
            <p class="legal"><strong><b>Make all cheque payable / Online Transfer to Bank Account Below.:</b></strong></p>
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
<!--

<div style="page-break-before: always;"></div> -->


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
