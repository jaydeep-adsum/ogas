@extends('dashboard')
@section('title')
    Notification
@endsection
@section('header')
    <div class="d-flex px-4 px-sm-0 pt-2 pt-sm-0">

    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger pb-0 pt-0">
                    <ul class="j-error-padding list-unstyled p-2 mb-0">
                        <li>{{ $errors->first() }}</li>
                    </ul>
                </div>
            @endif
            <div class="card card-default">
                <div class="card-body">
                    {{ Form::open(['route' => 'notification.store', 'files' => 'true']) }}
                    <div class="row">
                        <div class="form-group col-xl-8 col-md-8 col-sm-12">
                            {{ Form::label(__('User').':') }} <span class="mandatory">*</span>
                            {{ Form::select('user', ['Customer','Driver'],null, ['class' => 'form-control','required','id'=>'user_id']) }}
                        </div>
                        <div class="form-group col-xl-8 col-md-8 col-sm-12">
                            {{ Form::label(__('title').':') }} <span class="mandatory">*</span>
                            {{ Form::text('title', null, ['class' => 'form-control','required']) }}
                        </div>
                        <div class="form-group col-xl-8 col-md-8 col-sm-12">
                            {{ Form::label(__('description').':') }} <span class="mandatory">*</span>
                            {{ Form::textarea('description', null, ['class' => 'form-control','required','rows'=>'3']) }}
                        </div>
                        <div class="form-group text-right col-xl-8 col-md-8 col-sm-12 pt-4">
                            {{ Form::submit(__('Send Notification'), ['class' => 'btn btn-primary save-btn']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
                <div class="card card-default">
                <div class="card-body table-responsive">
                    @include('notification.table')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#user_id").select2({
            width: '100%',
        });
        let notificationUrl = "{{route('notification')}}";
    </script>
    <script src="{{asset('public/assets/js/notification/notification.js')}}"></script>
@endsection
