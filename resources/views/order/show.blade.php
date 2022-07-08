@extends('dashboard')
@section('title')
    Show Order
@endsection
@section('header')
    <a href="{{ route('order') }}" class="btn btn-default"><i class="fa-solid fa-arrow-left mr-1"></i>{{__('Back')}}
    </a>
@endsection
@section('content')
    <style>

    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="card card-default">
                            <div class="card-body">
                                <h3 class="border-bottom">Order Detail</h3>
                                <div class="row">
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
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="col-md-4">{{ Form::label(__('product ').':') }}</div>
                                            <div class="col-md-8"> {{ $order->product1->product_name }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="col-md-4">{{ Form::label(__('type ').':') }}</div>
                                            <div class="col-md-8">{{ ($order->type1==1)?'Refill':'New' }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="col-md-4">{{ Form::label(__('quantity ').':') }}</div>
                                            <div class="col-md-8">{{ $order->quantity1 }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div
                                                class="col-md-4 border-top">{{ Form::label(__('driver_tip ').':') }}</div>
                                            <div
                                                class="col-md-8 border-top">{{ $order->driver_tip?$order->driver_tip:0 }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if(isset($order->product2))
                                        <div class="d-flex">
                                            <div class="col-md-4">{{ Form::label(__('product ').':') }}</div>
                                            <div class="col-md-8"> {{ $order->product2->product_name }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="col-md-4">{{ Form::label(__('type ').':') }}</div>
                                            <div class="col-md-8">{{ ($order->type2==1)?'Refill':'New' }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="col-md-4">{{ Form::label(__('quantity ').':') }}</div>
                                            <div class="col-md-8">{{ $order->quantity2 }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="col-md-4 border-top">{{ Form::label(__('total ').':') }}</div>
                                            <div class="col-md-8 border-top">{{ $order->total }}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="border-bottom">Delivery Status</h3>
                            @if($cancel==5)
                                <div class="pt-3 col-md-12 text-danger text-center font-weight-bold"><h5 class="">Order
                                        Has
                                        Been Canceled.</h5></div>
                            @else
                                <div class="p-2 mt-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            @foreach($order->status as $status)
                                                <div class="col-md-2 border-bottom border-danger"><img
                                                        class="{{($status->status>0)?'float-right':''}}"
                                                        src="{{asset('public/assets/images/delivery-vehicle.png')}}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2 border-top"><h5>Ordered</h5></div>
                                            <div class="col-md-2 border-top"><h5 class="float-right">Confirmed</h5>
                                            </div>
                                            <div class="col-md-2 border-top"><h5 class="float-right">On The Way</h5>
                                            </div>
                                            <div class="col-md-2 border-top"><h5 class="float-right">Order
                                                    Processing</h5>
                                            </div>
                                            <div class="col-md-2 border-top"><h5 class="float-right">Delivered</h5>
                                            </div>
                                            <div class="col-md-2 border-top"><h5 class="float-right">Canceled</h5></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
