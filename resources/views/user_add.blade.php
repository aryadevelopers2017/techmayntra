@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Add New Staff </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Staff</li>
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
                                    <form action="{{ url('/add_user') }}" id="formsubmit" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" id="name" name="name" required class="form-control" placeholder="Name">
                                                    <span id="errname" style="display:none;color: #ff0000;">Please Enter Name</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email Id</label>
                                                    <input type="email" id="email" name="email" required class="form-control" placeholder="Email">
                                                    <span id="erremail" style="display:none;color: #ff0000;">Please Enter Email</span>
                                                    <span id="erralreadyemail" style="display:none;color: #ff0000;">Email Already Exists</span>
                                                    <span id="errvalidemail" style="display:none;color: #ff0000;">Please Enter Valid Email</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Password </label>
                                                    <input type="password" id="password" name="password" required class="form-control" placeholder="Enter Password">
                                                    <span id="emppass" style="display:none;color: #ff0000;">Please Enter Email</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" id="confirm_password" name="password_confirmation" required class="form-control" placeholder="Enter Confirm Password">
                                                    <span id="empconfirm_pass" style="display:none;color: #ff0000;">Please Enter Confirm Email</span>
                                                    <span id="errconfirm_pass" style="display:none;color: #ff0000;">Password and Confirm Email are not same</span>
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
let emailValid = false; // flag to track if email is available

// Submit button click
$("#finalbtn").click(function() {
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var confirm_password = $("#confirm_password").val();

    $("#name").parent().removeClass("has-error");
    $("#email").parent().removeClass("has-error");

    // Basic validation
    if(name == '' || name == null) {
        $("#errname").show(0).delay(3500).hide(0);
        $("#name").parent().addClass("has-error");
        $("#name").focus();
        return false;
    }
    if(email == '' || email == null) {
        $("#erremail").show(0).delay(3500).hide(0);
        $("#email").parent().addClass("has-error");
        $("#email").focus();
        return false;
    }
    if(!emailValid) { // check email availability
        $("#erralreadyemail").show(0).delay(3500).hide(0);
        $("#email").parent().addClass("has-error");
        $("#email").focus();
        return false;
    }
    if(password == '' || password == null) {
        $("#emppass").show(0).delay(3500).hide(0);
        $("#password").parent().addClass("has-error");
        $("#password").focus();
        return false;
    }
    if(confirm_password == '' || confirm_password == null) {
        $("#empconfirm_pass").show(0).delay(3500).hide(0);
        $("#confirm_password").parent().addClass("has-error");
        $("#confirm_password").focus();
        return false;
    }
    if(password != confirm_password) {
        $("#errconfirm_pass").show(0).delay(3500).hide(0);
        $("#confirm_password").parent().addClass("has-error");
        $("#confirm_password").focus();
        return false;
    }

    // All good, submit form
    $("#formsubmit").submit();
});

// Check email availability on focusout
$("#email").focusout(function () {
    var email = $("#email").val();


    if(email == '' || email == null) {

        return;
    }

    // disable button until AJAX finishes
    $("#finalbtn").prop('disabled', true);


    $.ajax({
        type: "POST",
        url: "{{ url('/user_add_checkemail') }}",
        data: {'email': email, '_token': "{{ csrf_token() }}"},
        success: function(result) {
    result = result.trim(); // <-- remove extra whitespace


    if(result !== 'success') {
        emailValid = false; // email exists

        $("#erralreadyemail").show(0).delay(3500).hide(0);
        $("#email").parent().addClass("has-error");
        $("#email").focus();
    } else {
        emailValid = true; // email available

        $("#erralreadyemail").hide();
        $("#email").parent().removeClass("has-error");
    }

    // re-enable button
    $("#finalbtn").prop('disabled', false);

},
        error: function(xhr, status, error) {
            console.error("[DEBUG] AJAX error:", status, error);
            emailValid = false;
            $("#erralreadyemail").show();
            $("#email").parent().addClass("has-error");
            $("#finalbtn").prop('disabled', false);
        }
    });
});


// Only allow numbers in certain inputs
$(".number").on('keypress focusout', function(event) {
    this.value = this.value.replace(/[^0-9\.]/g,'');
});
</script>


@endsection
