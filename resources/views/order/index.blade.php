@extends('dashboard')
@section('title')
    Orders
@endsection
@section('header')
    <div class="d-flex px-4 px-sm-0 pt-2 pt-sm-0">
        <a href="{{route('orders.export')}}" class="btn btn-primary"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-body table-responsive">
                    @include('order.table')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let orderUrl = "{{route('order')}}";
    </script>
    <script src="{{asset('public/assets/js/order/order.js')}}"></script>
@endsection
