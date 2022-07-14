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
                    <div class="col-12 form-group">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-{{$div}}">
                                        <div class="row">
                                            <h3 class="col-12 border-bottom">Order Detail</h3>
                                            <div class="col-md-4">{{ Form::label(__('Order ID').':') }}</div>
                                            <div class="col-md-8"> {{ $order->id }}</div>
                                            <div class="col-md-4">{{ Form::label(__('Delivery Date ').':') }}</div>
                                            <div
                                                class="col-md-8"> {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</div>
                                            <div class="col-md-4">{{ Form::label(__('time_slot ').':') }}</div>
                                            <div class="col-md-8"> @if($order->time_slot==0)
                                                    {{'Now'}}
                                                @elseif($order->time_slot==1)
                                                    {{'9AM - 12PM'}}
                                                @elseif($order->time_slot==2)
                                                    {{'12PM - 3PM'}}
                                                @elseif($order->time_slot==3)
                                                    {{'3PM - 6PM'}}
                                                @endif</div>
                                            <div class="col-md-4">{{ Form::label(__('location ').':') }}</div>
                                            <div class="col-md-8"> {{ $order->location }}</div>
                                            <div class="col-md-4">{{ Form::label(__('driver_tip ').':') }}</div>
                                            <div class="col-md-8">{{ $order->driver_tip?$order->driver_tip:0 }}</div>
                                            <div class="col-md-4">{{ Form::label(__('total ').':') }}</div>
                                            <div class="col-md-8">{{ $order->total }}</div>
                                        </div>
                                    </div>
                                    @if($div==4)
                                        <div class="col-md-{{$div}}">
                                            <div class="row">
                                                <h3 class="col-12 border-bottom">Driver Detail</h3>
                                                <div class="col-md-3">{{ Form::label(__('Driver ').':') }}</div>
                                                <div class="col-md-9"> {{ $order->driver->name }}</div>
                                                <div class="col-md-3">{{ Form::label(__('mobile ').':') }}</div>
                                                <div class="col-md-9"> {{ $order->driver->mobile }}</div>
                                                <div class="col-md-3">{{ Form::label(__('Email ').':') }}</div>
                                                <div class="col-md-9"> {{ $order->driver->email }}</div>
                                                <div class="col-md-3">{{ Form::label(__('licence_no ').':') }}</div>
                                                <div class="col-md-9"> {{ $order->driver->licence_no }}</div>
                                                <div class="col-md-3">{{ Form::label(__('vehicle_no ').':') }}</div>
                                                <div class="col-md-9"> {{ $order->driver->vehicle_no }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-{{$div}}">
                                        <div class="row">
                                            <h3 class="col-12 border-bottom">Customer Detail</h3>
                                            <div class="col-md-3">{{ Form::label(__('customer ').':') }}</div>
                                            <div class="col-md-9"> {{ $order->customer->name }}</div>
                                            <div class="col-md-3">{{ Form::label(__('mobile ').':') }}</div>
                                            <div class="col-md-9"> {{ $order->customer->mobile }}</div>
                                            @if($order->customer->address)
                                                <div class="col-md-3">{{ Form::label(__('address ').':') }}</div>
                                                <div class="col-md-9"> {{ $order->customer->address }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <div class="card card-default">
                            <div class="card-body">
                                <table id="orderHistoryTbl" class="table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>{{ Form::label(__('product')) }}</th>
                                        <th>{{ Form::label(__('type ')) }}</th>
                                        <th>{{ Form::label(__('quantity ')) }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->orderHistory as $orderHistory)
                                        <tr>
                                            <td>{{ $orderHistory->product->product_name }}</td>
                                            <td>{{ ($orderHistory->type==1)?'Refill':'New' }}</td>
                                            <td>{{ $orderHistory->quantity }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#orderHistoryTbl').DataTable();
        });
    </script>
@endsection
