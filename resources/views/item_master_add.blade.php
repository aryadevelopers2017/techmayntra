@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Item </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Item Master</li>
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
                                            <label>Item Name</label>
                                            <input type="text" id="item_name" name="item_name" required class="form-control" placeholder="Item Name" value="{{ isset($data->item_name) ? $data->item_name : '' }}">
                                            <span id="erritem_name" style="display:none;color: #ff0000;">Please Enter Item Name</span>
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
        $('.modal-footer').css('padding', '5px');

        $('.tox-notifications-container').css('display', 'none !important');

        $('.summernote').summernote();
    });
</script>
@endsection
