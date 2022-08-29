@extends('dashboard')
@section('title')
    Orders
@endsection
@section('header')
    <div class="d-flex px-4 px-sm-0 pt-2 pt-sm-0">
        <div class="mr-2">
            {{ Form::select('payment', ['Paid','Unpaid'],null, ['class' => 'form-control','id'=>'payment','placeholder'=>'Select Payment Status']) }}
        </div>
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
        .order_invoice_badge{
            background-color: #fff2e0;
            color: #f9a134;
        }
        .badge-paid-success{
            background-color: #c1f3ce;
            color: #249128;
        }
        .badge-unpaid-danger{
            background-color: #ffe0e0;
            color: #f93434;
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
        $("#status_id,#payment").select2();
        let orderUrl = "{{route('order')}}";
    </script>
    <script src="{{asset('public/assets/js/order/order.js')}}"></script>
@endsection
