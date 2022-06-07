@extends('dashboard')
@section('title')
    Show Order
@endsection
@section('header')
    <a href="{{ route('order') }}" class="btn btn-default"><i class="fa-solid fa-arrow-left mr-1"></i>{{__('Back')}}
    </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="card card-default">
                            <div class="card-body">
                                <h3 class="border-bottom">Order Detail</h3>
                                <div class="row">
                                <div class="col-md-3">{{ Form::label(__('product_id ').':') }}</div>
                                <div class="col-md-9"> {{ $order->product->product_name }}</div>
                                <div class="col-md-3">{{ Form::label(__('customer_id ').':') }}</div>
                                <div class="col-md-9"> {{ $order->customer->name }}</div>
                                    <div class="col-md-3">{{ Form::label(__('date ').':') }}</div>
                                    <div class="col-md-9"> {{ $order->date }}</div>
                                    <div class="col-md-3">{{ Form::label(__('time_slot ').':') }}</div>
                                    <div class="col-md-9"> @if($order->time_slot==0)
                                            {{'Now'}}
                                        @elseif($order->time_slot==1)
                                            {{'9AM - 12PM'}}
                                        @elseif($order->time_slot==2)
                                            {{'12PM - 3PM'}}
                                        @elseif($order->time_slot==3)
                                            {{'3PM - 6PM'}}
                                        @endif</div>
                                    <div class="col-md-3">{{ Form::label(__('location ').':') }}</div>
                                    <div class="col-md-9"> {{ $order->location }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="card card-default">
                            <div class="card-body">
                                <h3 class="border-bottom">Order Invoice</h3>
                                <div class="row">
                                    <div class="col-md-3">{{ Form::label(__('type ').':') }}</div>
                                    <div class="col-md-9">{{ ($order->type==1)?'Refill':'New' }}</div>
                                    <div class="col-md-3">{{ Form::label(__('Amount ').':') }}</div>
                                    <div class="col-md-9">{{ $order->total-(isset($order->driver_tip)?$order->driver_tip:0) }}</div>
                                    <div class="col-md-3">{{ Form::label(__('quantity ').':') }}</div>
                                    <div class="col-md-9">{{ $order->quantity }}</div>
                                    <div class="col-md-3">{{ Form::label(__('driver_tip ').':') }}</div>
                                    <div class="col-md-9">{{ $order->driver_tip?$order->driver_tip:0 }}</div>
                                    <div class="col-md-3 border-top">{{ Form::label(__('total ').':') }}</div>
                                    <div class="col-md-9 border-top">{{ $order->total }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
