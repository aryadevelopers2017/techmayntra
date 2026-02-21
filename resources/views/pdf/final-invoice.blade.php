<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
             margin: 110px 30px 80px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
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
                    <strong style="font-size:22px;">Receipt</strong> <br>
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
        {{-- INVOICE HEADER --}}

        <table width="100%" cellspacing="0" class="no-border" cellpadding="0" style="border-collapse:collapse; ">
    <tr>

        {{-- BILL TO BOX --}}
        <td width="50%" style="vertical-align:top; padding-right:10px;">
            <table width="100%" cellspacing="0" class="no-border" cellpadding="0" style="border:1px solid #000; border-collapse:collapse;">

                <tr>
                    <td style="background:#72cac5;color:#000000; padding:6px; font-weight:bold; text-align:center; border-bottom:1px solid #000;">
                        Receipt To
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

        {{-- INVOICE INFO HEADER TABLE --}}

        <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse; padding:5px;">

            <tr style="background:#72cac5; color: #000000;">
                <td style="border:1px solid #000; padding:6px; font-weight:bold; text-align:center;">
                    Title
                </td>
                <td style="border:1px solid #000; padding:6px; font-weight:bold; text-align:center;">
                    Receipt Date
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
@php
    $i = 1;
    $subTotal = 0;
    $totalVat = 0;
    $grandTotal = 0;
@endphp

        <table style="padding: 5px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Price ({{ $data['currency_data']->symbol }})</th>
                    <th> Qty / Unit </th>
                    <th> Amount ({{ $data['currency_data']->symbol }})</th>
                    <th>VAT (5%)</th>
                    <th>Total ({{ $data['currency_data']->symbol }})</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($data['item_data'] as $item)

                     @php
    $qty = (float) $item->qty;
    $totalWithVat = (float) $item->net_price;

    $vatPercent = (float) ($item->tax_value ?? 0);

    $vatAmount = ($totalWithVat * $vatPercent) / (100 + $vatPercent);
    $amountWithoutVat = $totalWithVat - $vatAmount;

    $rowprice = $qty > 0 ? ($amountWithoutVat / $qty) : 0;

    // totals
    $subTotal += $amountWithoutVat;
    $totalVat += $vatAmount;
    $grandTotal += $totalWithVat;
@endphp



                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td style="width:30%">{{ $item->item_name }}</td>
                   <td class="text-right">{{ number_format($rowprice, 2) }}</td>
                    <td class="text-right">{{ $item->qty }} {{ $item->qty_name }}</td>
                       <td class="text-right">{{ number_format($amountWithoutVat, 2) }}</td>
                    <td class="text-right">{{ number_format($vatAmount, 2) }}</td>
                    <td class="text-right"> {{ number_format($totalWithVat, 2) }} </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- TOTALS --}}

         <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; padding:5px;">
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

        {{-- BANK DETAILS --}}

        <div style="padding:5px;"  class="row">
                 <strong>Amount in words:</strong> {{ $data['amount_word'] }}  <br>


                 <strong><b>Make all cheque payable / Online Transfer to Bank Account Below.:</b></strong>
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

        </div>

        <div class="legalcopy" style="text-align: right;">
            <!-- <img  id="invoice-logo" src="{{ asset('asset/images/'.$data['company_data']->company_logo) }}" height="50px" alt=""/> -->
            <img
                src="{{ public_path('asset/images/paid.webp') }}"
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

        </div>

    </main>
</body>
</html>
