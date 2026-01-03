@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Client </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Client Master</li>
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
                                    <form action="{{ url('/add_client') }}" id="clientformsubmit" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="form-group">
                                            <label>Client Name</label>
                                            <input type="text" id="client_name" name="client_name" required class="form-control" placeholder="Client Name">
                                            <span id="errclient_name" style="display:none;color: #ff0000;">Please Enter Client Name</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" id="company_name" name="company_name" required class="form-control" placeholder="Company Name">
                                            <span id="errcompany_name" style="display:none;color: #ff0000;">Please Enter Company Name</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="email" id="email" name="email" required class="form-control" placeholder="Email">
                                            <span id="erremail" style="display:none;color: #ff0000;">Please Enter Email</span>
                                            <span id="errvalidemail" style="display:none;color: #ff0000;">Please Enter Valid Email</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile No</label>
                                            <input type="text" id="mobile" name="mobile" required minlength="10" maxlength="10" class="form-control number" placeholder="Mobile">
                                            <span id="erremobile" style="display:none;color: #ff0000;">Please Enter Mobile No</span>
                                            <span id="errevalidmobile" style="display:none;color: #ff0000;">Enter Valid Mobile No</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Addreess</label>
                                            <div id="Address">
                                                <textarea class="summernote" id="address" name="address">
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" id="city" name="city" required class="form-control" placeholder="city">
                                        </div>
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" id="state" name="state" required class="form-control" placeholder="state">
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
        var client_name=$("#client_name").val();
        $("#client_name").parent().removeClass("has-error");
        if(client_name=='' || client_name == null)
        {
            $("#errclient_name").show(0).delay(3500).hide(0);
            $("#client_name").parent().addClass("has-error");
            $("#client_name").focus();
            return false;
        }
        var company_name=$("#company_name").val();
        if(company_name=='' || company_name == null)
        {
            $("#errcompany_name").show(0).delay(3500).hide(0);
            $("#company_name").parent().addClass("has-error");
            $("#company_name").focus();
            return false;
        }

        $("#clientformsubmit").submit();
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
