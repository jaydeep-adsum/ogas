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
        <div class="col-12">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <span>Order Id : </span>
                            <span class="badge badge-danger"><i class="fa-solid fa-hashtag"></i>{{ $order->invoice_id }}</span>
                            <small class="float-right">Delivery
                                Date: {{\Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</small>
                        </h4>
                    </div>
                </div>
                <div class="row invoice-info" style="margin-top:2rem">
                    @if($order->driver)
                        <div class="col-sm-4 invoice-col">
                            <h5><label>Driver Details</label></h5>
                            <div
                                class="col-md-12">{{ Form::label(__('Driver ').': ') }} {{ $order->driver->name }}</div>
                            <div
                                class="col-md-12">{{ Form::label(__('mobile ').': ') }} {{ $order->driver->mobile }}</div>
                            <div
                                class="col-md-12">{{ Form::label(__('Email ').': ') }} {{ $order->driver->email }}</div>
                            <div
                                class="col-md-12">{{ Form::label(__('licence_no ').': ') }} {{ $order->driver->licence_no }}</div>
                            <div
                                class="col-md-12">{{ Form::label(__('vehicle_no ').': ') }} {{ $order->driver->vehicle_no }}</div>
                        </div>
                    @endif
                    <div class="col-sm-4 invoice-col">
                        <h5><label>Customer Details</label></h5>
                        <div class="col-md-12">{{ Form::label(__('customer ').':') }}{{ $order->customer->name }}</div>
                        <div class="col-md-12">{{ Form::label(__('mobile ').':') }}{{ $order->customer->mobile }}</div>
                        <div class="col-md-12">{{ Form::label(__('email ').':') }}{{ $order->customer->email }}</div>
                        @if($order->customer->address)
                            <div
                                class="col-md-12">{{ Form::label(__('address ').':') }}{{ $order->customer->address }}</div>
                        @endif
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <h5><label>Order Detail</label></h5>
                        <div class="col-md-12">{{ Form::label(__('time_slot ').':') }}@if($order->time_slot==0)
                                {{'Now'}}
                            @elseif($order->time_slot==1)
                                {{'9AM - 12PM'}}
                            @elseif($order->time_slot==2)
                                {{'12PM - 3PM'}}
                            @elseif($order->time_slot==3)
                                {{'3PM - 6PM'}}
                            @endif</div>
                        <div class="col-md-12">
                        <label>{{ Form::label(__('order_status ').':') }} </label>
                        @if($order->status==0)
                            <span>Ordered</span>
                        @elseif ($order->status==1)
                            <span>Confirmed</span>
                        @elseif ($order->status==2)
                            <span>Ongoing</span>
                        @elseif ($order->status==3)
                            <span>Order Processing</span>
                        @elseif ($order->status==4)
                            <span>Delivered</span>
                        @elseif ($order->status==5)
                            <span>Canceled</span><br>
                            <label>Cancel Reason :-</label> <span>{{$order->cancel_reason??''}}</span>
                        @endif
                    </div>
                        <div class="col-md-12">{{ Form::label(__('location ').':') }} {{ $order->address->location }}</div>
                        {{--                        <div class="col-md-4">{{ Form::label(__('driver_tip ').':') }}{{ $order->driver_tip?$order->driver_tip:0 }}</div>--}}
                        <div class="col-md-12">{{ Form::label(__('total ').':') }}{{ $order->total }}</div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive" style="margin-top:3rem">
                        <table id="orderHistoryTbl" class="table table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>{{ Form::label(__('quantity')) }}</th>
                                <th>{{ Form::label(__('product')) }}</th>
                                <th>{{ Form::label(__('product price')) }}</th>
                                <th>{{ Form::label(__('type')) }}</th>
                                <th>{{ Form::label(__('Subtotal')) }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderHistory as $orderHistory)
                                <tr>
                                    <td>{{ $orderHistory->quantity }}</td>
                                    <td>{{ $orderHistory->product->product_name }}</td>
                                    <td>{{ $orderHistory->type==1?$orderHistory->product->refill_price:$orderHistory->product->new_price }}</td>
                                    <td>{{ ($orderHistory->type==1)?'Refill':'New' }}</td>
                                    <td>{{ ($orderHistory->type==1?$orderHistory->product->refill_price:$orderHistory->product->new_price)*$orderHistory->quantity }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-6">--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table">--}}
{{--                                <tr>--}}
{{--                                    <th style="width:50%">Subtotal:</th>--}}
{{--                                    <td>$250.30</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th>Tax (9.3%)</th>--}}
{{--                                    <td>$10.34</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th>Shipping:</th>--}}
{{--                                    <td>$5.80</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th>Total:</th>--}}
{{--                                    <td>$265.24</td>--}}
{{--                                </tr>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    {{--    <div class="row">--}}
    {{--        <div class="col-md-12">--}}
    {{--            <div class="col-md-12">--}}
    {{--                <div class="row">--}}
    {{--                    <div class="col-12 form-group">--}}
    {{--                        <div class="card card-default">--}}
    {{--                            <div class="card-body">--}}
    {{--                                <div class="row">--}}
    {{--                                    <div class="col-md-{{$div}}">--}}
    {{--                                        <div class="row">--}}
    {{--                                            <h3 class="col-12 border-bottom">Order Detail</h3>--}}
    {{--                                            <div class="col-md-4">{{ Form::label(__('Order ID').':') }}</div>--}}
    {{--                                            <div class="col-md-8"> {{ $order->id }}</div>--}}
    {{--                                            <div class="col-md-4">{{ Form::label(__('Delivery Date ').':') }}</div>--}}
    {{--                                            <div--}}
    {{--                                                class="col-md-8"> {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</div>--}}
    {{--                                            <div class="col-md-4">{{ Form::label(__('time_slot ').':') }}</div>--}}
    {{--                                            <div class="col-md-8"> @if($order->time_slot==0)--}}
    {{--                                                    {{'Now'}}--}}
    {{--                                                @elseif($order->time_slot==1)--}}
    {{--                                                    {{'9AM - 12PM'}}--}}
    {{--                                                @elseif($order->time_slot==2)--}}
    {{--                                                    {{'12PM - 3PM'}}--}}
    {{--                                                @elseif($order->time_slot==3)--}}
    {{--                                                    {{'3PM - 6PM'}}--}}
    {{--                                                @endif</div>--}}
    {{--                                            <div class="col-md-4">{{ Form::label(__('location ').':') }}</div>--}}
    {{--                                            <div class="col-md-8"> {{ $order->location }}</div>--}}
    {{--                                            <div class="col-md-4">{{ Form::label(__('driver_tip ').':') }}</div>--}}
    {{--                                            <div class="col-md-8">{{ $order->driver_tip?$order->driver_tip:0 }}</div>--}}
    {{--                                            <div class="col-md-4">{{ Form::label(__('total ').':') }}</div>--}}
    {{--                                            <div class="col-md-8">{{ $order->total }}</div>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                    @if($div==4)--}}
    {{--                                        <div class="col-md-{{$div}}">--}}
    {{--                                            <div class="row">--}}
    {{--                                                <h3 class="col-12 border-bottom">Driver Detail</h3>--}}
    {{--                                                <div class="col-md-3">{{ Form::label(__('Driver ').':') }}</div>--}}
    {{--                                                <div class="col-md-9"> {{ $order->driver->name }}</div>--}}
    {{--                                                <div class="col-md-3">{{ Form::label(__('mobile ').':') }}</div>--}}
    {{--                                                <div class="col-md-9"> {{ $order->driver->mobile }}</div>--}}
    {{--                                                <div class="col-md-3">{{ Form::label(__('Email ').':') }}</div>--}}
    {{--                                                <div class="col-md-9"> {{ $order->driver->email }}</div>--}}
    {{--                                                <div class="col-md-3">{{ Form::label(__('licence_no ').':') }}</div>--}}
    {{--                                                <div class="col-md-9"> {{ $order->driver->licence_no }}</div>--}}
    {{--                                                <div class="col-md-3">{{ Form::label(__('vehicle_no ').':') }}</div>--}}
    {{--                                                <div class="col-md-9"> {{ $order->driver->vehicle_no }}</div>--}}
    {{--                                            </div>--}}
    {{--                                        </div>--}}
    {{--                                    @endif--}}
    {{--                                    <div class="col-md-{{$div}}">--}}
    {{--                                        <div class="row">--}}
    {{--                                            <h3 class="col-12 border-bottom">Customer Detail</h3>--}}
    {{--                                            <div class="col-md-3">{{ Form::label(__('customer ').':') }}</div>--}}
    {{--                                            <div class="col-md-9"> {{ $order->customer->name }}</div>--}}
    {{--                                            <div class="col-md-3">{{ Form::label(__('mobile ').':') }}</div>--}}
    {{--                                            <div class="col-md-9"> {{ $order->customer->mobile }}</div>--}}
    {{--                                            @if($order->customer->address)--}}
    {{--                                                <div class="col-md-3">{{ Form::label(__('address ').':') }}</div>--}}
    {{--                                                <div class="col-md-9"> {{ $order->customer->address }}</div>--}}
    {{--                                            @endif--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-12 form-group">--}}
    {{--                        <div class="card card-default">--}}
    {{--                            <div class="card-body">--}}
    {{--                                <table id="orderHistoryTbl" class="table table-striped" style="width:100%">--}}
    {{--                                    <thead>--}}
    {{--                                    <tr>--}}
    {{--                                        <th>{{ Form::label(__('product')) }}</th>--}}
    {{--                                        <th>{{ Form::label(__('type ')) }}</th>--}}
    {{--                                        <th>{{ Form::label(__('quantity ')) }}</th>--}}
    {{--                                    </tr>--}}
    {{--                                    </thead>--}}
    {{--                                    <tbody>--}}
    {{--                                    @foreach($order->orderHistory as $orderHistory)--}}
    {{--                                        <tr>--}}
    {{--                                            <td>{{ $orderHistory->product->product_name }}</td>--}}
    {{--                                            <td>{{ ($orderHistory->type==1)?'Refill':'New' }}</td>--}}
    {{--                                            <td>{{ $orderHistory->quantity }}</td>--}}
    {{--                                        </tr>--}}
    {{--                                    @endforeach--}}
    {{--                                    </tbody>--}}
    {{--                                </table>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#orderHistoryTbl').DataTable();
        });
    </script>
@endsection
