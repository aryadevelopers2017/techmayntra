@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
<div class="main">
<div class="container-fluid">

<div class="row">
    <div class="col-lg-8 col-md-6  p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Add Service Category</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6  p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Service Category</li>
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

<form action="{{ url('/add_service_category') }}" method="POST" id="formsubmit">
@csrf

<div class="row">
<div class="col-lg-6">

    <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
        <span id="errname" class="text-danger" style="display:none">Enter Category Name</span>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
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

<script>
$("#finalbtn").click(function(){
    if($("#name").val()==''){
        $("#errname").show().delay(3000).hide();
        return false;
    }
    $("#formsubmit").submit();
});
</script>
@endsection
