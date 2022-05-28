@extends('dashboard')
@section('title')
    Edit Product
@endsection
@section('header')
    <a href="{{ route('products') }}" class="btn btn-default"><i class="fa-solid fa-arrow-left mr-1"></i>{{__('Back')}}
    </a>
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
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        {{ Form::model($product, ['route' => ['products.update',$product->id], 'files' => 'true']) }}
                        <div class="row">
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('product_name').':') }} <span class="mandatory">*</span>
                                {{ Form::text('product_name', null, ['class' => 'form-control','required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('Category').':') }} <span class="mandatory">*</span>
                                {{ Form::select('category_id', $category,null, ['class' => 'form-control','required','id'=>'category_id']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('refill_price').':') }} <span class="mandatory">*</span>
                                {{ Form::number('refill_price', null, ['class' => 'form-control', 'required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('new_price').':') }} <span class="mandatory">*</span>
                                {{ Form::number('new_price', null, ['class' => 'form-control','required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('Image').':') }}
                                <div>
                                    <label class='file-label btn btn-primary mr-2'><i
                                            class="fa-solid fa-image mr-2"></i></i>Choose Image
                                        {{ Form::file('image') }}
                                    </label>
                                </div>
                                <div class="">
                                    <img src="{{$product->image_url}}" width="80px" height="80px"
                                         class="rounded shadow">
                                </div>
                            </div>
                            <div class="form-group col-sm-12 pt-4">
                                {{ Form::submit(__('Save'), ['class' => 'btn btn-primary save-btn']) }}
                                <a href="{{ route('products') }}"
                                   class="btn btn-default">{{__('Cancel')}}</a>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $("#category_id").select2({
            width: '100%',
        });
    </script>
@endsection
