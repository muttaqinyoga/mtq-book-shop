@extends('layouts.app')
@section('title') Edit Book @endsection
@section('content')
<!-- BREADCRUMB-->
<section class="au-breadcrumb m-t-75 bg-dark">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35 text-white">Book</h3>
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
                            <h3 class="text-center title-2">Edit Book</h3>
                        </div>
                        <hr>
                        <form action="{{ url('book/update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" id="id" value="{{$book->id}}">
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
                                <label for="title" class="control-label mb-1">Book Title</label>
                                <input id="title" name="title" type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $book->title }}">
                                @if ($errors->has('title'))
                                <small class="help-block form-text text-danger">{{ $errors->first('title') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="author" class="control-label mb-1">Book Author</label>
                                <input id="author" name="author" type="text" class="form-control {{ $errors->has('author') ? ' is-invalid' : '' }}" value="{{ $book->author }}">
                                @if ($errors->has('author'))
                                <small class="help-block form-text text-danger">{{ $errors->first('author') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="category_id" class="control-label mb-1">Book Categories</label>
                                <select name="category_id[]" multiple id="category_id" class="form-control">
                                    @foreach($book->categories as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                <small class="help-block form-text text-danger">{{ $errors->first('category_id') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="image" class="control-label mb-1">Book Image</label>
                                <div class="book-priview">
                                    <img src="{{asset('storage/'.$book->cover)}}" width="100" height="100">
                                </div>
                                <small class="help-block form-text text-danger">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                <input type="file" id="image" name="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                                @if ($errors->has('image'))
                                <small class="help-block form-text text-danger">{{ $errors->first('image') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="price" class="control-label mb-1">Book Price</label>
                                <input id="price" name="price" type="number" min="0" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ $book->price }}">
                                @if ($errors->has('price'))
                                <small class="help-block form-text text-danger">{{ $errors->first('price') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="stock" class="control-label mb-1">Book Stock</label>
                                <input id="stock" name="stock" type="number" min="0" class="form-control {{ $errors->has('stock') ? ' is-invalid' : '' }}" value="{{ $book->stock }}">
                                @if ($errors->has('stock'))
                                <small class="help-block form-text text-danger">{{ $errors->first('stock') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="publisher" class="control-label mb-1">Book Publisher</label>
                                <input id="publisher" name="publisher" type="text" class="form-control {{ $errors->has('publisher') ? ' is-invalid' : '' }}" value="{{ $book->publisher }}">
                                @if ($errors->has('publisher'))
                                <small class="help-block form-text text-danger">{{ $errors->first('publisher') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label mb-1">Book description</label>
                                <textarea id="description" rows="4" name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ $book->description }}</textarea>
                                @if ($errors->has('description'))
                                <small class="help-block form-text text-danger">{{ $errors->first('description') }}</small>
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
@section('data-tables2')
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-select2.min.css') }}">
<script src="{{ asset('vendor/bootstrap-select2.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#category_id').select2({
            ajax: {
                url: "{{ url('categories/ajax/search') }}",
                processResults: function(categories) {
                    return {
                        results: categories.map(function(c) {
                            return {
                                id: c.id,
                                text: c.name
                            }
                        })
                    }
                }
            }
        });
    });
</script>
@endsection