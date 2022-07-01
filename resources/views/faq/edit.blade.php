<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Faq') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'editForm']) }}
            <div class="modal-body">
                {{ Form::hidden('faqId',null,['id'=>'faqId']) }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('question',__('Question').':') }}<span class="mandatory">*</span>
                        {{ Form::text('question', null, ['class' => 'form-control','required','id'=>'editQuestion']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('answer',__('Answer').':') }}<span class="mandatory">*</span>
                        {{ Form::textarea('answer', null, ['class' => 'form-control','required','id'=>'editAnswer','rows'=>'5']) }}
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
