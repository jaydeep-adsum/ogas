@extends('dashboard')
@section('title')
    Faq
@endsection
@section('header')
    <a href="#" class="btn btn-primary addModal"><i class="fa-solid fa-plus"></i> Add</a>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-body table-responsive">
                    @include('faq.table')
                </div>
            </div>
        </div>
        @include('faq.create')
        @include('faq.edit')
    </div>
@endsection
@section('scripts')
    <script>
        let faqUrl = "{{route('faq.index')}}";
        let faqSaveUrl = "{{ route('faq.store') }}";
    </script>
    <script src="{{asset('public/assets/js/faq/faq.js')}}"></script>
@endsection
