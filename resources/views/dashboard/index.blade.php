@extends('dashboard')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-success">
                    <a href="{{route('customer')}}">
                        <div class="card-body py-4 px-4">
                            <span style="font-size: 40px;"><i class="fa-solid fa-user-group"></i></span>
                            <h2 class="fw">{{$data['customer']?$data['customer']:0}}</h2>
                            <p>Customers</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info">
                    <a href="{{route('products')}}">
                        <div class="card-body py-4 px-4">
                            <span style="font-size: 40px;"><i class="fas fa-gas-pump"></i></span>
                            <h2 class="fw">{{$data['product']?$data['product']:0}}</h2>
                            <p>Products</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
