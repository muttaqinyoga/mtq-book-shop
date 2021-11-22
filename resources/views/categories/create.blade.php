@extends('layouts.app')
@section('title') Create Category @endsection
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
                            <h3 class="text-center title-2">Create New Category</h3>
                        </div>
                        <hr>
                        <form action="{{ url('categories/save') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="control-label mb-1">Category Name</label>
                                <input id="name" name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <small class="help-block form-text text-danger">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="image" class="control-label mb-1">Category Image</label>
                                <input type="file" id="image" name="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                                @if ($errors->has('image'))
                                <small class="help-block form-text text-danger">{{ $errors->first('image') }}</small>
                                @endif
                            </div>
                            <div>
                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                    Create
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