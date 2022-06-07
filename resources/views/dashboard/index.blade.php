@extends('dashboard')
@section('title')
    {{__('Dashboard')}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary">
                    <a href="{{route('customer')}}">
                        <div class="card-body py-4 px-4">
                            <span style="font-size: 40px;"><i class="fa-solid fa-user-group"></i></span>
                            <h2 class="fw">{{$data['customer']?$data['customer']:0}}</h2>
                            <p>{{ __('Customers') }}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success">
                    <a href="{{route('products')}}">
                        <div class="card-body py-4 px-4">
                            <span style="font-size: 40px;"><i class="fas fa-gas-pump"></i></span>
                            <h2 class="fw">{{$data['product']?$data['product']:0}}</h2>
                            <p>{{__('Products')}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info">
                    <a href="{{route('order')}}">
                        <div class="card-body py-4 px-4">
                            <span style="font-size: 40px;"><i class="fa-solid fa-clipboard-check"></i></span>
                            <h2 class="fw">{{$data['order']?$data['order']:0}}</h2>
                            <p>{{__('Orders')}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger">
                    <a href="{{route('feedback')}}">
                        <div class="card-body py-4 px-4">
                            <span style="font-size: 40px;"><i class="fa-solid fa-comments"></i></span>
                            <h2 class="fw">{{$data['complaint']?$data['complaint']:0}}</h2>
                            <p>{{__('Complaint')}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
