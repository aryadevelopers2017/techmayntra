@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Proforma Invoice Payment </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Proforma Invoice Payment</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{ url('/add_proforma_invoice_payment') }}" id="proforma_invocieform" method="POST">
                                        <input type="hidden" name="id" id="id" value="{{ $data[0]->id }}" />
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Proforma Invoice No </label>
                                                    <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Proforma Invoice No" value="{{ $data[0]->invoice_no }} " disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Custmer </label>
                                                        <input type="text" class="form-control" id="c_id" name="c_id" placeholder="Customer" value="{{ $data[0]->name .'-'.$data[0]->company_name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Title </label>
                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" disabled value="{{ $data[0]->title }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Total Amount ({{ $data[0]->symbol }})</label>
                                                    <input type="text" class="form-control number" id="total_amount" value="{{ $data[0]->total_amount }}" min="0" readonly placeholder="Total Amount">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Received Amount ({{ $data[0]->symbol }})</label>
                                                    <input type="text" class="form-control number" id="paid_amount" value="{{ $data[0]->paid_amount }}" min="0" readonly placeholder="GST (%)">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Remaining Amount ({{ $data[0]->symbol }})</label>
                                                    <input type="text" class="form-control number" id="remain_amt" value="{{ $data[0]->total_amount - $data[0]->paid_amount }}" min="0" readonly placeholder="GST (%)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Payment Currency</label>
                                                    <select class="select2" name="currency_country_code" id="currency_country_code">
                                                        <option value="" disabled selected>Please Select Payment Currency</option>
                                                        @foreach($currency as $curr)
                                                            @if($data[0]->currency_id == $curr->id)
                                                                <option value="{{ $curr->id }}" selected>{{ $curr->country_name }} {{ $curr->name }} {{ $curr->symbol }}</option>
                                                            @else
                                                                <option value="{{ $curr->id }}">{{ $curr->country_name }} {{ $curr->name }} {{ $curr->symbol }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Current Currency Amount</label>
                                                <div class="form-group">
                                                    <input type="text" name="per_currency_amount" id="per_currency_amount" required value="1" class="form-control number">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Payable Currency Amount</label>
                                                <div class="form-group">
                                                    <input type="text" name="payable_currency_amount" id="payable_currency_amount" required readonly class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="radio" class="radio" id="part" name="payment_type" value="part" required><strong>&nbsp;&nbsp;&nbsp;Full</strong><br> 
                                                    <input type="radio" class="radio" id="partial" name="payment_type" value="partial" required><strong>&nbsp;&nbsp;&nbsp;Partial</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-4" id="amt" style="display: none;">
                                                <div class="form-group">
                                                    <label>Please Enter Payment (%)</label>
                                                    <input type="text" class="form-control number" id="payment_per" name="payment_per" value="" min="0" max="100" placeholder="Enter Percentage(%)">
                                                </div>
                                            </div>
                                            <div class="col-lg-4" id="amt1" style="display: none;">
                                                <div class="form-group">
                                                    <label>Payment Amount ({{ $data[0]->symbol }})</label>
                                                    <input type="text" class="form-control number" id="payment_amount" name="payment_amount" readonly min="0" max="100" placeholder="Enter Amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>GST (%)</label>
                                                    <input type="text" class="form-control number" id="gst_per" value="{{ $data[0]->gst_per }}" disabled max="100" min="0" disabled placeholder="GST (%)">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>After Pending Amount ({{ $data[0]->symbol }})</label>
                                                    <input type="text" class="form-control number" id="remain_amount" readonly disabled placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        @if($data[0]->status==1)
                                            <button type="submit" id="finalbtn" class="btn btn-primary">Submit</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
    function calculate_amount()
    {
        var total_amount=$("#total_amount").val();
        var payment_per=$("#payment_per").val();
        var remain_amt=$("#remain_amt").val();
        var per_currency_amount=$("#per_currency_amount").val();
        var amount=0;

        if(parseFloat(payment_per)>100 || parseFloat(payment_per)<0)
        {
            $("#payment_per").val(0);
        }

        var amount=((parseFloat(total_amount)*parseFloat(payment_per))/100).toFixed(2);
        var remin_amt=(parseFloat(total_amount)-parseFloat(amount)).toFixed(2);
        var payable_currency_amount=(parseFloat(per_currency_amount)*parseFloat(amount)).toFixed(2);

        if(parseFloat(amount)>parseFloat(remain_amt))
        {
            $("#payment_per").val('');
            $("#payment_per").focus();
            $("#remain_amount").val(0);
            $("#payment_amount").val(0);
        }
        else
        {
            $("#remain_amount").val(remin_amt);
            $("#payment_amount").val(amount);
            $("#payable_currency_amount").val(payable_currency_amount);
        }
        
    }

    $("#finalbtn").click(function(e)
    {
    });

    $(".number").on('keypress keyup focusout', function(event)
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
        calculate_amount();
    });

    $("input[name='payment_type']").on('change', function()
    {
        var type=$("input[name='payment_type']:checked").val();
        var per_currency_amount=$("#per_currency_amount").val();
        $("#amt").css("display", "none");
        $("#amt1").css("display", "none");
        $("#payment_per").attr("required", false);
        
        if(type!='part')
        {
            $("#amt").css("display", "block");
            $("#amt1").css("display", "block");
            $("#payment_per").attr("required", true);
        }
        else
        {
            var amt=$("#pedning_amount").val();
            $("#payment_per").val(100);
            $("#payment_amount").val('');
            if(amt>0)
            {
                var payable_currency_amount=(parseFloat(amt)*parseFloat(per_currency_amount)).toFixed(2);
                $("#payment_amount").val(amt);
                $("#payable_currency_amount").val(payable_currency_amount);
            }
        }
    });
</script>
@endsection
