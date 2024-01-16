<div class="lf-nav-tab">
    <a class="nav-link {{ is_current_route(['profile.index','profile.edit'],'active') }}"
       href="{{ route('profile.index') }}">{{ __('Profile') }}</a>
    <a class="nav-link {{ is_current_route('profile.change-password','active') }}"
       href="{{ route('profile.change-password') }}">{{ __('Change Password') }}</a>
    <a class="nav-link {{ is_current_route('profile.avatar.edit','active') }}"
       href="{{ route('profile.avatar.edit') }}">{{ __('Change Avatar') }}</a>
</div>
