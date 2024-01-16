<!-- Start: comment form -->
<div class="comment-form">
    {{ Form::open(['route'=>['comment.store', $auction->id],'class'=>'form-horizontal', 'id' => 'parentComment']) }}
    @method('post')
        <div class="form-row">
            <div class="col-12">
                {{ Form::textarea('content', null, ['class' => 'form-control color-666', 'id' => 'content','placeholder' => __('Comment'), 'rows' => 3]) }}
                <span class="invalid-feedback" data-name="content">{{ $errors->first('content') }}</span>
                <button value="Submit" type="submit" class="btn btn-info float-right form-submission-button mt-3">{{__('Submit')}}</button>
            </div>
        </div>
    {{ Form::close() }}
</div>
<!-- Start: comment form -->
