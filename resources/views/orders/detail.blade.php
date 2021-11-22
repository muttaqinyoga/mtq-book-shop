@extends('layouts.app')
@section('title') Detail Order @endsection
@section('content')
<!-- BREADCRUMB-->
<section class="au-breadcrumb m-t-75 bg-dark">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35 text-white">Orders</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END BREADCRUMB-->
<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Detail Order</h3>
                        </div>
                        <div class="card-content">
                            <form>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Invoice Number</label>
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control-plaintext" value="{{$invoice_number}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Buyer</label>
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control-plaintext" value="{{$customer_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Address</label>
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control-plaintext" value="{{$address}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Time</label>
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control-plaintext" value="{{$order_date}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Items</label>
                                    <div class="col-md-9">
                                        <ol>
                                            @foreach($order as $o)
                                            <li>{{$o->title}} ({{'Rp. ' . number_format($o->price, 0, ',', '.')}}) * ({{$o->quantity}}) pcs</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Total</label>
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control-plaintext" value="{{$total_price}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Status</label>
                                    <div class="col-md-9">
                                        <span class="badge 
                                            @if($status=='SUBMIT')
                                            bg-warning
                                            @elseif($status=='PROCESS')
                                            bg-info
                                            @elseif($status=='FINISH')
                                            bg-success
                                            @else
                                            bg-danger
                                            @endif
                                            {{ $status=='SUBMIT' ? 'text-dark' : 'text-light' }}">{{$status}}</span>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('data-tables2')
<script>

</script>
@endsection