@extends('dashboard')
@section('title')
    Orders
@endsection
@section('header')
    <div class="d-flex px-4 px-sm-0 pt-2 pt-sm-0">
        <div class="mr-2">
            {{ Form::select('status', $status,null, ['class' => 'form-control','id'=>'status_id','placeholder'=>'Select Order Status']) }}
        </div>
        <a href="{{route('orders.export')}}" class="btn btn-primary btn-sm"><i class="fa-solid fa-file-excel"></i> {{__('Export Excel')}}</a>
    </div>
@endsection
@section('content')
    <style>
        .order_id_badge{
            background-color: #e0e3ff;
            color: #6571ff;
        }
    </style>
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
        $("#status_id ").select2();
        let orderUrl = "{{route('order')}}";
    </script>
    <script src="{{asset('public/assets/js/order/order.js')}}"></script>
@endsection
