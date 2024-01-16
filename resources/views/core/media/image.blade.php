<div class="col-md-3 col-sm-4 col-6 mb-4">
    <div class="media-box border">
        <img src="{{$mediaPath}}" alt=""
             class="cm-lb-img-link">
        <div class="media-footer">
            <p class="p-2 bg-grey-light mb-0 lf-media-name">{{ $mediaName }}</p>
            <div class="media-menu d-flex align-items-center bg-dark  p-2">
                <button class="btn text-light copy-button p-0 lf-tooltip"
                        data-clipboard-text="{{ $mediaPath }}"
                        data-title="{{__('Copy Link')}}"
                ><i class="fa fa-clipboard"></i></button>
                <a class="ml-auto text-warning confirmation"
                   href="{{ route('admin.media.destroy',$mediaId) }}"
                   data-form-method="delete" data-form-id="{{ $mediaId }}"
                   data-alert="{{__('Are you sure?')}}"
                   data-toggle="tooltip"
                   title="{{__('Delete')}}"><i class="fa fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>
