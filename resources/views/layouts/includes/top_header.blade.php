<header class="lf-template-header py-lg-3{{ $headerClass }}">  <!--header-transparent header-light-->
    <div class="container">
        <div class="row align-items-center{{ $navigationType }}">
            <!-- menu -->
            <div class="col-lg-10 col-md-12 order-lg-0 order-2 py-lg-0 py-3">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 flex-lg-grow-0">
                        <a href="{{route('home')}}" class="lf-logo{{ $inversedLogoClass }}"> <!-- lf-logo-inversed -->
                            <img src="{{ company_logo() }}" class="img-fluid" alt="">
                        </a>
                        @if($isSideNavActive)
                            <a href="javascript:;" class="lf-side-nav-controller lf-side-nav-toggler"><i class="fa fa-bars"></i></a>
                        @endif
                    </div>
                    @if($isTopNavActive)
                    <div class="flex-lg-grow-1">
                        <nav class="d-lg-block d-none">
                            {{ get_nav('top-nav') }}
                        </nav>
                        <div class="lf-responsive-menu-wrapper d-lg-none d-block"></div>
                    </div>
                    @endif
                </div>
            </div>
            <!-- user option -->
            <div class="col-lg-2 order-lg-0 order-0 px-lg-2">
                <ul class="d-flex justify-content-center align-items-center lf-user-menu">
                    @guest
                    <li>
                        <a href="{{route('login')}}">{{__('Login')}}</a>
                    </li>
                    <li>
                        <a href="{{route('register.index')}}">{{__('Signup')}}</a>
                    </li>
                    @endguest
                    @auth
                    @php
                        $userNotifications = get_user_specific_notice();
                    @endphp
                    <li>
                        <div class="btn-group lf-user-notification">
                            <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fa fa-bell-o notification-icon"></i>
                                <div class="lf-notification-count">{{ $userNotifications['count_unread'] }}</div>
                            </button>
                            @if(!empty($userNotifications['list']->count()))
                            <div class="dropdown-menu dropdown-menu-right">
                                <span class="dropdown-header">{{ __('You have :count notifications',['count' => $userNotifications['count_unread']]) }}</span>

                                @foreach($userNotifications['list'] as $notification)
                                    <a class="dropdown-item {{$notification->link == null ? 'disabled' : ''}}" href="{{$notification->link == null ? 'javascript:;' : $notification->link }}">
                                        <i class="fa fa-bell text-warning"></i>
                                        {{view_html($notification->message)}}
                                    </a>
                                @endforeach
                                <a class="btn btn-info text-center all-notification" href="{{ route('notifications.index') }}">{{__('See All Notifications')}}</a>
                            </div>
                            @endif
                        </div>
                    </li>
                    <li>
                        <div class="btn-group lf-user-dropdown">
                            <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fa fa-user"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header">
                                    <div class="d-flex pb-2">
                                        <div class="avatar">
                                            <img src="{{get_avatar(auth()->user()->avatar)}}" alt="" class="img-fluid">
                                        </div>
                                        <div class="user-info">
                                            <h6>{{auth()->user()->profile->full_name}}</h6>
                                            <div>{{auth()->user()->username}}</div>
                                        </div>
                                    </div>
                                    <a class="btn btn-info btn-sm" href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Log out</a>
                                </div>
                                {{ get_nav('profile-nav', 'profile_dropdown') }}
                            </div>
                        </div>
                    </li>
                    @endauth
                    @if(settings('lang_switcher'))
                        <li>
                            <div class="btn-group lf-language">
                                <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="">{{ display_language(App::getLocale()) }}</div>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach(language() as $language => $parameter)
                                        <a class="dropdown-item"
                                           href="{{ generate_language_url($language) }}">
                                            {{ display_language($language, $parameter) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>

