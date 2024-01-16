<div class="bg-light text-muted clearfix p-3 lf-toggle-border-color border border-bottom-0">
    <h5 class="float-left">{{ $title }}</h5>
    @isset($indexUrl)
    <div class="float-right">
        <a href="{{ $indexUrl }}"
           class="btn btn-info btn-sm back-button"><i class="fa fa-reply"></i></a>
    </div>
    @endisset
</div>
<div class="card lf-toggle-bg-card lf-toggle-border-color">
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
