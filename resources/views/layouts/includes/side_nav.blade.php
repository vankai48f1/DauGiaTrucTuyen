<div class="lf-side-nav{{$sideLogoClass}}{{ $openSideNavClass }}">
    <div class="lf-side-nav-handler lf-side-nav-controller"><i class="fa fa-arrow-circle-left"></i></div>
    <div class="lf-side-nav-logo d-table w-100">
        <a href="{{route('home')}}"
           class="align-middle p-2 d-table-cell lf-logo{{ $inversedSideNavLogoClass }}">
            <!-- lf-logo-inversed -->
            <img src="{{ company_logo() }}" class="img-fluid" alt="">
        </a>
    </div>
    <div class="lf-side-nav-wrapper">
        <nav id="lf-side-nav">
            {{ get_nav('side-nav', 'side_nav') }}
        </nav>
    </div>

</div>
