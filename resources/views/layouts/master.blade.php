@php
    $bodyClass = $wrapperClass = $openSideNavClass = '';
    $sideLogoClass = '';
    if(isset($cmbPage)){
        $headerClass = $cmbPage->settings['top_nav_transparent'] ? ' header-transparent' : ($cmbPage->settings['top_nav'] == 1 ? " header-light" : '');
        $isTopNavActive = in_array($cmbPage->settings['navigation_type'], [0,2]);
        $navigationType = $isTopNavActive ? '' : ' justify-content-center';
        $inversedLogoClass = $cmbPage->settings['logo_inversed_top_nav']  ? ' lf-logo-inversed' : '';
        $inversedSideNavLogoClass = $cmbPage->settings['logo_inversed_side_nav']  ? ' lf-logo-inversed' : '';
        $isSideNavActive = auth()->check() && auth()->user()->assigned_role == USER_ROLE_ADMIN && in_array($cmbPage->settings['navigation_type'], [1,2]);

        if($isSideNavActive && $cmbPage->settings['side_nav_fixed']){
            $bodyClass =  ' lf-fixed-sidenav';
            $wrapperClass = ' lf-fixed-sidenav-wrapper';
            $openSideNavClass = ' lf-side-nav-open';
        }

        if($cmbPage->settings['side_nav']==1){
            $sideLogoClass =' lf-white-side-nav';
        }
        elseif($cmbPage->settings['side_nav']==2){
            $sideLogoClass =' lf-dark-transparent-side-nav';
        }
        elseif($cmbPage->settings['side_nav']==3){
            $sideLogoClass =' lf-white-transparent-side-nav';
        }

    }else{
        $headerClass = isset($transparentHeader) && $transparentHeader ? ' header-transparent' : (settings('top_nav')==1 ? " header-light" : '');
        $isTopNavActive = in_array(settings('navigation_type'), [0,2]);
        $navigationType = $isTopNavActive ? '' : ' justify-content-center';
        $inversedLogoClass = isset($inversedLogo) ? ($inversedLogo  ? ' lf-logo-inversed' : '') : (!empty(settings('logo_inversed_primary')) ? ' lf-logo-inversed' : '');
        $inversedSideNavLogoClass = isset($inversedSideNavLogo) ? ($inversedSideNavLogo  ? ' lf-logo-inversed' : '') : (!empty(settings('logo_inversed_sidenav')) ? ' lf-logo-inversed' : '');
        $isSideNavActive = (!isset($activeSideNav) && in_array(settings('navigation_type'), [1,2])) || (isset($activeSideNav) && $activeSideNav);
        if($isSideNavActive){
            if(isset($fixedSideNav)){
                if($fixedSideNav){
                    $bodyClass = ' lf-fixed-sidenav';
                    $wrapperClass = ' lf-fixed-sidenav-wrapper';
                    $openSideNavClass = ' lf-side-nav-open';
                }
            }else{
                if(settings('navigation_type') && settings('side_nav_fixed')){
                    $bodyClass = ' lf-fixed-sidenav';
                    $wrapperClass = ' lf-fixed-sidenav-wrapper';
                    $openSideNavClass = ' lf-side-nav-open';
                }
            }
        }
        if(settings('side_nav')==1){
            $sideLogoClass =' lf-white-side-nav';
        }
        elseif(settings('side_nav')==2){
            $sideLogoClass =' lf-dark-transparent-side-nav';
        }
        elseif(settings('side_nav')==3){
            $sideLogoClass =' lf-white-transparent-side-nav';
        }
    }
@endphp

@include('layouts.includes.header')

@if(isset($headerLess) && $headerLess)
    <div class="centralize-wrapper">
        <div class="centralize-inner">
            <div class="centralize-content lf-no-header-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
@else
    @include('layouts.includes.top_header')

    @includeWhen((!isset($hideBreadcrumb) || !$hideBreadcrumb), 'layouts.includes.breadcrumb')

    <div class="content-wrapper">

        <div class="content">
            @yield('content')
            @yield('extended-content')
        </div>
    </div>

    @include('layouts.includes.footer')

    @include('layouts.includes.notice')
@endif
@include('layouts.includes.script')
