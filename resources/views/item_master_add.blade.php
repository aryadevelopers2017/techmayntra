@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                              @if(isset($data->id))
                            <h1>Edit Service</h1>
                             @else
                            <h1>Add New Service </h1>
                             @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Service Master</li>
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
                                    @if(isset($data->id))
                                        <form action="{{ url('/edit_item_master') }}" id="itemformsubmit" method="POST">
                                            <input type="hidden" name="id" value="{{ $data->id }}" />
                                    @else
                                        <form action="{{ url('/add_item_master') }}" id="itemformsubmit" method="POST">
                                    @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="form-group">
                                            <label>Service Name</label>
                                            <input type="text" id="item_name" name="item_name" required class="form-control" placeholder="Service Name" value="{{ isset($data->item_name) ? $data->item_name : '' }}">
                                            <span id="erritem_name" style="display:none;color: #ff0000;">Please Enter Item Name</span>
                                        </div>


                                        <div class="form-group">
                                            <label>Vendor</label>
                                            <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                                                <option value="">Select Vendor</option>
                                                @foreach($data['vendors'] as $vendor)
                                                    <option value="{{ $vendor->id }}"
                                                        {{ isset($data->vendor_id) && $data->vendor_id == $vendor->id ? 'selected' : '' }}>
                                                        {{ $vendor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="errvendor" class="text-danger d-none">Please select vendor</span>
                                        </div>

                                        <div class="form-group">
                                            <label>Admin Cost</label>
                                            <input type="number" step="0.01" name="admin_cost" id="admin_cost"
                                                class="form-control"
                                                value="{{ $data->admin_cost ?? '' }}"
                                                placeholder="Enter Admin Cost">
                                        </div>

                                        <div class="form-group">
                                            <label>Tax Type</label><br>

                                            <label>
                                                <input type="radio" name="tax_type" value="GST"
                                                    {{ (isset($data->tax_type) && $data->tax_type == 'GST') ? 'checked' : (!isset($data->tax_type) ? 'checked' : '') }}
                                                    onclick="changeTaxType('GST')">
                                                GST
                                            </label>

                                            &nbsp;&nbsp;

                                            <label>
                                                <input type="radio" name="tax_type" value="VAT"
                                                    {{ (isset($data->tax_type) && $data->tax_type == 'VAT') ? 'checked' : '' }}
                                                    onclick="changeTaxType('VAT')">
                                                VAT
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label id="tax_label">{{ isset($data->tax_type) && $data->tax_type == 'VAT' ? 'VAT %' : 'GST %' }}</label>

                                            <input type="number" max="100" min="0" id="tax_value" name="tax_value"
                                                class="form-control"
                                                placeholder="{{ isset($data->tax_type) && $data->tax_type == 'VAT' ? 'VAT %' : 'GST %' }}"
                                                value="{{ $data->tax_value ?? '' }}">

                                            <span id="errtaxvalue" style="display:none;color:#ff0000;">
                                                Tax percentage cannot be greater than 100
                                            </span>
                                        </div>

                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category_id" id="category_id" class="form-control select2" required>
                                                    <option value="">Select Category</option>
                                                    @foreach($data['categories'] as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            {{ isset($data->category_id) && $data->category_id == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Sub Category</label>
                                                <select name="subcategory_id" id="subcategory_id" class="form-control select2">
                                                    <option value="">Select Sub Category</option>
                                                    @foreach($data['subcategories'] as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            {{ isset($data->subcategory_id) && $data->subcategory_id == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <div id="term">
                                                <textarea class="summernote" id="description" name="description">{{ isset($data->description) ? $data->description : '' }}
                                                </textarea>
                                            </div>
                                            <span id="errdescription" style="display:none;color: #ff0000;">Please Enter Description</span>
                                        </div>
                                        <button type="button" id="finalbtn" class="btn btn-primary">Submit</button>
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
    $("#finalbtn").click(function()
    {
        var item_name=$("#item_name").val();
        var description=$("#description").val().trim();
    var tax_value = $("#tax_value").val();

        $("#item_name").parent().removeClass("has-error");

        if(item_name=='' || item_name == null)
        {
            $("#erritem_name").show(0).delay(3500).hide(0);
            $("#item_name").parent().addClass("has-error");
            $("#item_name").focus();
            return false;
        }

        if(description=='' || description==null || description.length==0)
        {
            $("#errdescription").show(0).delay(3500).hide(0);
            $("#description").parent().addClass("has-error");
            $("#description").focus();
            return false;
        }


    if (tax_value != '' && parseFloat(tax_value) > 100) {
        $("#errtaxvalue").show(0).delay(3500).hide(0);
        $("#tax_value").parent().addClass("has-error");
        $("#tax_value").focus();
        return false;
    }


        $("#itemformsubmit").submit();
    });
</script>
<script>
    $( document ).ready(function()
    {
        $('#item_id').select2({
            dropdownParent: $('#myModal'),
            width:'100%'
        });

        $('.select2-container').css('display', 'inline-table');
        $('.select2-container').css('width', '100%');
        $('.modal-footer').css('padding', '5px');

        $('.tox-notifications-container').css('display', 'none !important');

        $('.summernote').summernote();
    });
</script>
<script>
$(document).ready(function () {

    $('#category_id').on('change', function () {

        let category_id = $(this).val();

        $('#subcategory_id')
            .empty()
            .append('<option value="">Loading...</option>');

        if (category_id) {
            $.ajax({
                url: "{{ url('get-subcategories') }}",
                type: "GET",
                data: { category_id: category_id },
                success: function (res) {

                    let options = '<option value="">Select Sub Category</option>';

                    $.each(res, function (i, item) {
                        options += `<option value="${item.id}">${item.name}</option>`;
                    });

                    $('#subcategory_id').html(options).trigger('change');

                }
            });
        } else {
            $('#subcategory_id').html('<option value="">Select Sub Category</option>');
        }
    });

});
</script>



<script>

$(document).ready(function () {
    var taxType = $("input[name='tax_type']:checked").val();
    changeTaxType(taxType);
});

function changeTaxType(type) {
    if(type == "GST") {
        document.getElementById("tax_label").innerText = "GST %";
        document.getElementById("tax_value").placeholder = "GST %";
    } else if(type == "VAT") {
        document.getElementById("tax_label").innerText = "VAT %";
        document.getElementById("tax_value").placeholder = "VAT %";
    }
}
</script>

@endsection
