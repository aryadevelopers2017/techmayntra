@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Change Password</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Change Password</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.Admin.messages')
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{ url('/updatepass') }}" id="formsubmit" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <strong>Email ID : {{ Auth::user()->email }} </strong>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Current Password</label>
                                                    <input type="password" id="currentpassword" name="currentpassword" required class="form-control" onfocusout="changepass()" placeholder="Enter Current Password">
                                                    <span id="curremppass" style="display:none;color: #ff0000;">Please Enter Current Password</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Password </label>
                                                    <input type="password" id="newpassword" name="newpassword" required class="form-control" onfocusout="changepass()" placeholder="Enter Password">
                                                    <span id="emppass" style="display:none;color: #ff0000;">Please Enter Password</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" id="confirm_password" name="confirm_password" required onfocusout="changepass()" class="form-control" placeholder="Enter Confirm Password">
                                                    <span id="empconfirm_pass" style="display:none;color: #ff0000;">Please Enter Confirm Password</span>
                                                    <span id="errconfirm_pass" style="display:none;color: #ff0000;">Password and Confirm Password are not same</span>
                                                </div>
                                            </div>
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
    function changepass()
    {
        var currentpassword=$("#currentpassword").val();
        var newpassword=$("#newpassword").val();
        var confirm_password=$("#confirm_password").val();

        if(currentpassword=='' || currentpassword == null)
        {
            $("#curremppass").show(0).delay(3500).hide(0);
            $("#currentpassword").parent().addClass("has-error");
            $("#currentpassword").focus();
            return false;
        }

        $("#currentpassword").parent().removeClass("has-error");

        if(newpassword=='' || newpassword == null)
        {
            $("#emppass").show(0).delay(3500).hide(0);
            $("#newpassword").parent().addClass("has-error");
            return false;
        }

        $("#newpassword").parent().removeClass("has-error");

        if(confirm_password=='' || confirm_password == null)
        {
            $("#empconfirm_pass").show(0).delay(3500).hide(0);
            $("#confirm_password").parent().addClass("has-error");
            return false;
        }

        $("#confirm_password").parent().removeClass("has-error");

        if(newpassword!=confirm_password)
        {
            $("#errconfirm_pass").show(0).delay(3500).hide(0);
            $("#confirm_password").parent().addClass("has-error");
            return false;   
        }

        $("#confirm_password").parent().removeClass("has-error");
        return true;
    }
    
    $("#finalbtn").click(function(e)
    {
        var flag=changepass();
        if(flag)
        {
            $("#finalbtn").attr('disabled', true);
            $("#formsubmit").submit();
        }
    });
    

    $(".number").on('keypress focusout', function(event)
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
</script>
@endsection