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
                <div class="card bg-warning">
                    <a href="{{route('driver')}}">
                        <div class="card-body py-4 px-4">
                            <span style="font-size: 40px;"><i class="fa-solid fa-taxi"></i></span>
                            <h2 class="fw">{{$data['driver']?$data['driver']:0}}</h2>
                            <p>{{ __('Drivers') }}</p>
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
            <div class="col-md-3">
                <div class="card bg-dark">
                    <a href="{{route('order')}}">
                        <div class="card-body py-4 px-4">
                            <span style="font-size: 40px;">ر.ع</span>
                            <h2 class="fw">{{$data['orderAmountTotal']?$data['orderAmountTotal']:0}}</h2>
                            <p>{{__('Total Order Amount')}}</p>
                        </div>
                    </a>
                </div>
            </div>
{{--            <div class="col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <canvas id="myChart" height="100px"></canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
@section('scripts')
{{--    @dd($data['product'])--}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">

        var labels =  {{ Js::from($data['product']) }};
        var users =  {{ Js::from($data['orderHistory']) }};
        const data = {
            labels: labels,
            datasets: [{
                label: 'Total Orders',
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255,0,56)',
                    'rgb(72,255,0)',
                    'rgb(54, 162, 235)',
                ],
                data: users,
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Order Details'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Products'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Product Sold'
                        },
                        min: 0,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        }
                    }
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

    </script>
@endsection
