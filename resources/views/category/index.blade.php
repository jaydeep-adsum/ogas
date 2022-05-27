@extends('dashboard')
@section('title')
    Category
@endsection
@section('header')
    <a href="#" class="btn btn-primary addModal"><i class="fa-solid fa-plus"></i> Add</a>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-body table-responsive">
                    @include('category.table')
                </div>
            </div>
        </div>
        @include('category.create')
        @include('category.edit')
    </div>
@endsection
@section('scripts')
    <script>
        let categoryUrl = "{{route('category.index')}}";
        let categorySaveUrl = "{{ route('category.store') }}";
    </script>
    <script src="{{asset('public/assets/js/category/category.js')}}"></script>
@endsection
