@extends('layouts.app')
@section('title') Edit Order @endsection
@section('content')
<!-- BREADCRUMB-->
<section class="au-breadcrumb m-t-75 bg-dark">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35 text-white">Order</h3>
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
                            <h3 class="text-center title-2">Edit Order</h3>
                        </div>
                        @if($failed = Session::get('failed'))
                        <div class="form-group">
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Failed</span>
                                {{ $failed }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        @if($errors->has('_nOrder'))
                        <div class="form-group">
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Error</span>
                                Unknown error occured!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        <hr>
                        <form action="{{ url('order/update') }}" id="orderForm" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="order_id" value="{{$order_id}}">
                            <div class="form-group">
                                <label for="buyer" class="control-label mb-1">Buyer</label>
                                <input id="buyer" name="buyer" type="text" class="form-control {{ $errors->has('buyer') ? ' is-invalid' : '' }}" value="{{ $customer_name }}" {{ $status!='SUBMIT' ? 'readonly disabled' : '' }}>
                                @if ($errors->has('buyer'))
                                <small class="help-block form-text text-danger">{{ $errors->first('buyer') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="address" class="control-label mb-1">Address</label>
                                <input id="address" name="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ $address }}" {{ $status!='SUBMIT' ? 'readonly disabled' : '' }}>
                                @if ($errors->has('address'))
                                <small class="help-block form-text text-danger">{{ $errors->first('address') }}</small>
                                @endif
                            </div>
                            <div id="item">
                                @foreach($order as $o => $v)
                                <div class="form-group {{$o!=0 ? 'item'.$o : ''}}">
                                    <label for="book">Item</label>
                                    <select name="book{{$o!=0 ? $o : ''}}" id="book{{$o!=0 ? $o : ''}}" class="form-control {{ $errors->has('book') ? ' is-invalid' : '' }}" {{ $status!='SUBMIT' ? 'readonly disabled' : '' }}>
                                        @foreach($books as $b)
                                        <option value="{{$b->id}}" {{ $v->title == $b->title ? 'selected' : '' }}>{{$b->title}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('book'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('book') }}</small>
                                    @endif
                                </div>
                                <div class="form-group {{$o!=0 ? 'item'.$o : ''}}">
                                    <label for="quantity" class="control-label mb-1">Quantity</label>
                                    <input id="quantity{{$o!=0 ? $o : ''}}" name="quantity{{$o!=0 ? $o : ''}}" type="number" min="0" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ $v->quantity }}" {{ $status!='SUBMIT' ? 'readonly disabled' : '' }}>
                                    @if ($errors->has('quantity'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('quantity') }}</small>
                                    @endif
                                </div>
                                <input type="hidden" name="_nOrder" id="_nOrder" value="{{$order->count()}}">
                                @if($o!=0 && $status=='SUBMIT')
                                <div class="form-group item{{$o}}">
                                    <button item="{{$o}}" type="button" class="btn btn-sm btn-danger remove">remove</button>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @if($status == 'SUBMIT')
                            <div class="form-group">
                                <button type="button" id="addNewItem" class="btn btn-sm btn-dark">add</button>
                            </div>
                            @endif
                            <div class="form-group">
                                <label>Status</label>
                                <div class="form-group">
                                    <div class="form-check-inline form-check">
                                        @if($status=="SUBMIT")
                                        <label for="SUBMIT" class="form-check-label mr-2">
                                            <input type="radio" id="SUBMIT" name="status" value="SUBMIT" class="form-check-input" {{$status=='SUBMIT' ? 'checked' : ''}}>SUBMIT
                                        </label>
                                        @endif
                                        <label for="PROCESS" class="form-check-label mr-2">
                                            <input type="radio" id="PROCESS" name="status" value="PROCESS" class="form-check-input" {{$status=='PROCESS' ? 'checked' : ''}}>PROCESS
                                        </label>
                                        <label for="FINISH" class="form-check-label ">
                                            <input type="radio" id="FINISH" name="status" value="FINISH" class="form-check-input" {{$status=='FINISH' ? 'checked' : ''}}>FINISH
                                        </label>
                                    </div>
                                    @if ($errors->has('status'))
                                    <small class="help-block form-text text-danger">{{ $errors->first('status') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="submitOrderBtn" class="btn btn-lg btn-warning btn-block">
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
<script>
    $('#orderForm').on('submit', function() {
        $('form #submitOrderBtn').attr('disabled', true);
        $('form #submitOrderBtn').text('Updating...');
    });
</script>
@if($status == 'SUBMIT')
<script>
    $(document).ready(function() {
        let i = 1;
        $(document).on('click', '#addNewItem', function() {
            $('#item').append(`<div class="form-group item${i}">
                                <label for="book${i}">Item</label>
                                <select name="book${i}" id="book${i}" class="form-control selectpicker {{ $errors->has('book${i}') ? ' is-invalid' : '' }}" data-live-search="true">
                                    <option value="" selected>--Choose items--</option>
                                    @foreach($books as $b)
                                    <option value="{{$b->id}}">{{$b->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('book${i}'))
                                <small class="help-block form-text text-danger">{{ $errors->first('book${i}') }}</small>
                                @endif
                            </div>
                            <div class="form-group item${i}">
                                <label for="quantity${i}" class="control-label mb-1">Quantity</label>
                                <input id="quantity${i}" name="quantity${i}" type="number" min="0" class="form-control {{ $errors->has('${i}') ? ' is-invalid' : '' }}" value="{{ old('${i}') }}">
                                @if ($errors->has('${i}'))
                                <small class="help-block form-text text-danger">{{ $errors->first('${i}') }}</small>
                                @endif
                            </div>
                            <div class="form-group item${i}">
                                <button item="${i}" type="button"  class="btn btn-sm btn-danger remove">remove</button>
                            </div>
                        `);
            i++;
            $('#_nOrder').val(i);
        });
        $(document).on('click', `.remove`, function() {
            const item = $(this).attr('item');
            $(`.item${item}`).remove();
        });
    });
</script>
@endif
@endsection