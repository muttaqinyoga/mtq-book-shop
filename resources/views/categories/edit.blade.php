@extends('layouts.app')
@section('title') Edit Category @endsection
@section('content')
<!-- BREADCRUMB-->
<section class="au-breadcrumb m-t-75 bg-dark">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35 text-white">Categories</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END BREADCRUMB-->
<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Edit Category</h3>
                        </div>
                        <hr>

                        <form action="{{ url('categories/update/'.$category->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if($message = Session::get('message'))
                            <div class="form-group">
                                <div class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                                    <span class="badge badge-pill badge-success">Success</span>
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="name" class="control-label mb-1">Category Name</label>
                                <input id="name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{old('name') ? old('name') : $category->name}}">
                                @if ($errors->has('name'))
                                <small class="help-block form-text text-danger">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="image" class="control-label mb-1">Category Image</label>
                                @if($category->image)
                                <span>Current image</span><br>
                                <img src="{{asset('storage/'. $category->image)}}" width="120px">
                                <br><br>
                                @endif
                                <input type="file" id="image" name="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                                <small class="text-muted">Let empty if you do not want change image</small>
                                @if ($errors->has('image'))
                                <small class="help-block form-text text-danger">{{ $errors->first('image') }}</small>
                                @endif
                            </div>
                            <div>
                                <button type="submit" class="btn btn-lg btn-warning btn-block">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection