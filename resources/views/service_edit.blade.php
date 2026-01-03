@extends('layouts.Admin.app')

@section('content')
<div class="content-wrap">
<div class="main">
<div class="container-fluid">

<div class="row">
    <div class="col-lg-8">
        <h1>Edit Service</h1>
    </div>
</div>

<section id="main-content">
<div class="card">
<div class="card-body">

<form action="{{ url('/update_service') }}" method="POST" id="formsubmit">
@csrf
<input type="hidden" name="id" value="{{ $data->id }}">

<div class="row">
<div class="col-lg-6">

    <div class="form-group">
        <label>Service Category</label>
        <select name="category_id" class="form-control" required>
            <option value="">Select Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $cat->id==$data->category_id?'selected':'' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Service Name</label>
        <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $data->description }}</textarea>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1"{{ $data->status==1?'selected':'' }}>Active</option>
            <option value="0"{{ $data->status==0?'selected':'' }}>Inactive</option>
        </select>
    </div>

</div>
</div>

<button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>
</div>
</section>

</div>
</div>
</div>
@endsection
