<div class="text-center mb-md-4 mb-3">
    <a href="{{route('home')}}" class="lf-logo">
        <img src="{{ company_logo() }}" class="img-fluid" alt="">
    </a>
</div>
@isset($pageTitle)
<h4 class="text-center mb-4">{{ $pageTitle }}</h4>
@endisset
<div class="lf-no-header-inner">
    <div class="m-lg-4">
        {{ $slot }}
    </div>
</div>
