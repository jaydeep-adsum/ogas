@extends('dashboard')
@section('title')
    Complaints
@endsection
@section('header')
    <div class="d-flex px-4 px-sm-0 pt-2 pt-sm-0">
{{--        <a href="{{route('student.create')}}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Add</a>--}}
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-body table-responsive">
                    @include('complaint.table')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let feedbackUrl = "{{route('feedback')}}";
    </script>
    <script src="{{asset('public/assets/js/complaint/complaint.js')}}"></script>
@endsection
