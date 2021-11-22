@extends('layouts.app')
@section('title') Orders @endsection
@section('data-tables')
<link href="{{ asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" media="all">
<link href="{{ asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" media="all">
@endsection
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
        @if($message = Session::get('message'))
        <div class="row mt-3">
            <div class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Success</span>
                {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
        @endif
        <div class="row mt-3 mb-3">
            <a class="au-btn au-btn-icon au-btn--green au-btn--small" href="{{url('order/create')}}">
                Create New Order
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="orders-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Invoice Number</th>
                                <th>Buyer</th>
                                <th>Time</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Menu Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteOrderModalLabel">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="deleteOrderContent">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="{{url('order/delete')}}" method="post" style="display: inline;" id="deleteOrderForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="delete_order_id" id="delete_order_id">
                    <button type="submit" class="btn btn-danger" id="deleteOrderBtn">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Menu Modal -->
@endsection
@section('data-tables2')
<script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('orders/datatables') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'invoice_number',
                    name: 'invoice_number'
                },
                {
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'order_date',
                    name: 'order_date'
                },

                {
                    data: 'total_price',
                    name: 'total_price'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false
                }
            ]
        });
        $(document).on('click', '#btnDeleteOrder', function() {
            const delete_order_id = $(this).attr('delete_order_id');
            const invoice_number = $(this).attr('invoice_number');
            $('#delete_order_id').attr('value', delete_order_id);
            $('#deleteOrderModal #deleteOrderContent').html(`<p>Are you sure want to cancel <strong>${invoice_number}</strong> from order list?</p>`);
        });
        $('#deleteOrderForm').on('submit', function() {
            $('form #deleteOrderBtn').attr('disabled', true);
            $('form #deleteOrderBtn').text('Canceling...');
        });
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
@endsection