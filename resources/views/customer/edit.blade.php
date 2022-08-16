<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Customer') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'editForm']) }}
            <div class="modal-body">
                {{ Form::hidden('customerId',null,['id'=>'customerId']) }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('name',__('Name').':') }}<span class="mandatory">*</span>
                        {{ Form::text('name', null, ['class' => 'form-control','required','id'=>'editName']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('mobile',__('Mobile').':') }}
                        {{ Form::number('mobile', null, ['class' => 'form-control','disabled','id'=>'editMobile']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('email',__('Email').':') }}<span class="mandatory">*</span>
                        {{ Form::email('email', null, ['class' => 'form-control','required','id'=>'editEmail']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('payment_customer_id',__('Payment Customer ID').':') }}<span class="mandatory">*</span>
                        {{ Form::text('payment_customer_id', null, ['class' => 'form-control','required','id'=>'editCustomerId']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('address',__('Address').':') }}<span class="mandatory">*</span>
                        {{ Form::textarea('address', null, ['class' => 'form-control','required','id'=>'editAddress','rows'=>'3']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('Save'), ['type'=>'submit','class' => 'btn btn-primary']) }}
                    <button type="button" class="btn btn-default ml-1"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
