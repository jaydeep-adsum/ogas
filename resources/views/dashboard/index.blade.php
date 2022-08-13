@extends('dashboard')
@section('title')
    {{__('Dashboard')}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            {{--            <div class="col-md-3">--}}
            {{--                <div class="card bg-primary">--}}
            {{--                    <a href="{{route('customer')}}">--}}
            {{--                        <div class="card-body py-4 px-4">--}}
            {{--                            <span style="font-size: 40px;"><i class="fa-solid fa-user-group"></i></span>--}}
            {{--                            <h2 class="fw">{{$data['customer']?$data['customer']:0}}</h2>--}}
            {{--                            <p>{{ __('Customers') }}</p>--}}
            {{--                        </div>--}}
            {{--                    </a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="col-md-3">--}}
            {{--                <div class="card bg-warning">--}}
            {{--                    <a href="{{route('driver')}}">--}}
            {{--                        <div class="card-body py-4 px-4">--}}
            {{--                            <span style="font-size: 40px;"><i class="fa-solid fa-taxi"></i></span>--}}
            {{--                            <h2 class="fw">{{$data['driver']?$data['driver']:0}}</h2>--}}
            {{--                            <p>{{ __('Drivers') }}</p>--}}
            {{--                        </div>--}}
            {{--                    </a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="col-md-3">--}}
            {{--                <div class="card bg-success">--}}
            {{--                    <a href="{{route('products')}}">--}}
            {{--                        <div class="card-body py-4 px-4">--}}
            {{--                            <span style="font-size: 40px;"><i class="fas fa-gas-pump"></i></span>--}}
            {{--                            <h2 class="fw">{{$data['product']?$data['product']:0}}</h2>--}}
            {{--                            <p>{{__('Products')}}</p>--}}
            {{--                        </div>--}}
            {{--                    </a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="col-md-3">--}}
            {{--                <div class="card bg-info">--}}
            {{--                    <a href="{{route('order')}}">--}}
            {{--                        <div class="card-body py-4 px-4">--}}
            {{--                            <span style="font-size: 40px;"><i class="fa-solid fa-clipboard-check"></i></span>--}}
            {{--                            <h2 class="fw">{{$data['order']?$data['order']:0}}</h2>--}}
            {{--                            <p>{{__('Orders')}}</p>--}}
            {{--                        </div>--}}
            {{--                    </a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="col-md-3">--}}
            {{--                <div class="card bg-danger">--}}
            {{--                    <a href="{{route('feedback')}}">--}}
            {{--                        <div class="card-body py-4 px-4">--}}
            {{--                            <span style="font-size: 40px;"><i class="fa-solid fa-comments"></i></span>--}}
            {{--                            <h2 class="fw">{{$data['complaint']?$data['complaint']:0}}</h2>--}}
            {{--                            <p>{{__('Complaint')}}</p>--}}
            {{--                        </div>--}}
            {{--                    </a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="col-md-3">--}}
            {{--                <div class="card bg-dark">--}}
            {{--                    <a href="{{route('order')}}">--}}
            {{--                        <div class="card-body py-4 px-4">--}}
            {{--                            <span style="font-size: 40px;">ر.ع</span>--}}
            {{--                            <h2 class="fw">{{$data['orderAmountTotal']?$data['orderAmountTotal']:0}}</h2>--}}
            {{--                            <p>{{__('Total Order Amount')}}</p>--}}
            {{--                        </div>--}}
            {{--                    </a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart" height="100px"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header justify-content-end pb-0">
                        <div id="daterange_textbox" class="time_range time_range_width w-30">
                            <i class="far fa-calendar-alt"
                               aria-hidden="true"></i>&nbsp;&nbsp;<span></span> <b
                                class="caret"></b>
                        </div>
                    </div>
                    <div class="card-body mt-0">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="card border">
                                    <div class="card-header justify-content-between">
                                        <h4>Customers</h4>
                                    </div>
                                    <div class="card-body p-0 mt-0" id="customerContainer">
                                        <canvas id="customerChart" width="1025" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="card border">
                                    <div class="card-header justify-content-between">
                                        <h4>Drivers</h4>
                                    </div>
                                    <div class="card-body p-0 mt-0" id="driverContainer">
                                        <canvas id="driverChart" width="515" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header justify-content-end pb-0">
                        <div id="dateRange" class="time_range time_range_width w-30">
                            <i class="far fa-calendar-alt"
                               aria-hidden="true"></i>&nbsp;&nbsp;<span></span> <b
                                class="caret"></b>
                        </div>
                    </div>
                    <div class="card-body p-0 mt-0" id="incomeContainer">
{{--                        <canvas id="incomeChart" height="100px"></canvas>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let ChartData = "{{ route('dashboard.chart.data') }}";
        let IncomeData = "{{ route('income.chart.data') }}";
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            let timeRange = $('#daterange_textbox');
            let isPickerApply = false;
            const today = moment();
            let start = today.clone().startOf('week');
            let end = today.clone().endOf('days');

            timeRange.on('apply.daterangepicker', function (ev, picker) {
                isPickerApply = true;
                start = picker.startDate.format('YYYY-MM-D  H:mm:ss');
                end = picker.endDate.format('YYYY-MM-D  H:mm:ss');
                loadCustomerData(start, end);
            });

            window.cb = function (start, end) {
                timeRange.find('span').html(
                    start.format('MMM D, YYYY') + ' - ' +
                    end.format('MMM D, YYYY'));
            };

            timeRange.daterangepicker({
                startDate: start,
                endDate: end,
                opens: 'left',
                showDropdowns: true,
                autoUpdateInput: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'This Week': [moment().startOf('week'), moment().endOf('week')],
                    'Last Week': [
                        moment().startOf('week').subtract(7, 'days'),
                        moment().startOf('week').subtract(1, 'days')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],

                },
            }, cb);

            cb(start, end);

            window.loadCustomerData = function (startDate, endDate) {
                $.ajax({
                    type: 'GET',
                    url: ChartData,
                    dataType: 'json',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                    },
                    cache: false,
                }).done(
                    driverChart,
                    customerStatistics,
                );
            };

            window.driverChart = function (result) {
                $('#driverContainer').html('');
                $('canvas#driverChart').remove();
                $('#driverContainer').append('<canvas id="driverChart" width="515" height="413"></canvas>');

                const driverData = {
                    labels: result.labels,
                    datasets: [
                        {
                            label: 'Drivers',
                            backgroundColor: '#6777ef',
                            data: result.driver,
                        }],
                };
                let ctx = $('#driverChart');
                let config = new Chart(ctx, {
                    type: 'bar',
                    data: driverData,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                min: 0,
                                max: 100,
                                ticks: {
                                    stepSize: 10
                                }
                            }
                        }
                    },
                });
            };

            window.customerStatistics = function (result) {
                $('#customerContainer').html('');
                $('canvas#customerChart').remove();
                $('#customerContainer').append('<canvas id="customerChart" width="1031" height="400"></canvas>');

                const customerLineChartData = {
                    labels: result.labels,
                    datasets: [{
                        label: 'Customers',
                        data: result.customer,
                        backgroundColor: '#1C75BC',
                    }]
                };

                let customerStatistics = $('#customerChart');

                let myChart = new Chart(customerStatistics, {
                    type: 'bar',
                    data: customerLineChartData,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                min: 0,
                                max: 100,
                                ticks: {
                                    stepSize: 10
                                }
                            }
                        }
                    }
                });
            }
            loadCustomerData(start.format('YYYY-MM-D H:mm:ss'),
                end.format('YYYY-MM-D H:mm:ss'));
        });

        var labels = {{ Js::from($data['product']) }};
        var users = {{ Js::from($data['orderHistory']) }};
        const data = {
            labels: labels,
            datasets: [{
                label: 'Total Orders',
                data: users,
                backgroundColor: [
                    'rgba(245,136,35,0.36)',
                ],
                borderColor: [
                    'rgb(245,136,35)',
                ],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
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
    <script>
        $(document).ready(function () {
            let dateRange = $('#dateRange');
            let isIncomePickerApply = false;
            const today = moment();
            let start = today.clone().startOf('week');
            let end = today.clone().endOf('days');

            dateRange.on('apply.daterangepicker', function (ev, picker) {
                isIncomePickerApply = true;
                start = picker.startDate.format('YYYY-MM-D  H:mm:ss');
                end = picker.endDate.format('YYYY-MM-D  H:mm:ss');
                loadIncomeData(start, end);
            });

            window.cb = function (start, end) {
                dateRange.find('span').html(
                    start.format('MMM D, YYYY') + ' - ' +
                    end.format('MMM D, YYYY'));
            };

            dateRange.daterangepicker({
                startDate: start,
                endDate: end,
                opens: 'left',
                showDropdowns: true,
                autoUpdateInput: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'This Week': [moment().startOf('week'), moment().endOf('week')],
                    'Last Week': [
                        moment().startOf('week').subtract(7, 'days'),
                        moment().startOf('week').subtract(1, 'days')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],

                },
            }, cb);

            cb(start, end);

            window.loadIncomeData = function (startDate, endDate) {
                $.ajax({
                    type: 'GET',
                    url: IncomeData,
                    dataType: 'json',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                    },
                    cache: false,
                }).done(
                    incomeChart,
                );
            };

            window.incomeChart = function (result) {
                $('#incomeContainer').html('');
                $('canvas#incomeChart').remove();
                $('#incomeContainer').append('<canvas id="incomeChart" width="515" height="413"></canvas>');

                const incomeData = {
                    labels: result.labels,
                    datasets: [
                        {
                            label: 'Drivers',
                            backgroundColor: '#6777ef',
                            data: result.driver,
                        }],
                };
                let ctx = $('#incomeChart');
                let config = new Chart(ctx, {
                    type: 'bar',
                    data: driverData,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                min: 0,
                                max: 100,
                                ticks: {
                                    stepSize: 10
                                }
                            }
                        }
                    },
                });
            };

            window.customerStatistics = function (result) {
                $('#customerContainer').html('');
                $('canvas#customerChart').remove();
                $('#customerContainer').append('<canvas id="customerChart" width="1031" height="400"></canvas>');

                const customerLineChartData = {
                    labels: result.labels,
                    datasets: [{
                        label: 'Customers',
                        data: result.customer,
                        backgroundColor: '#1C75BC',
                    }]
                };

            loadIncomeData(start.format('YYYY-MM-D H:mm:ss'),
                end.format('YYYY-MM-D H:mm:ss'));
        });
    </script>
@endsection
