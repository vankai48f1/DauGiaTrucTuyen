<div class="common-nav">
    <ul class="nav nav-tabs" id="profileTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ is_current_route(['profile.index', 'profile.edit'],'active') }}"
               href="{{ route('profile.index') }}">{{ __('Personal Information') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ is_current_route('profile.change-password','active') }}"
               href="{{ route('profile.change-password') }}">{{ __('Change Password') }}</a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link {{ is_current_route(['kyc.addresses.index', 'kyc.addresses.create', 'kyc.addresses.edit', 'kyc.addresses.verification.create', 'kyc.addresses.verification.show'],'active') }}"
                href="{{ route('kyc.addresses.index') }}"
            >
                {{ __('My Addresses') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ is_current_route(['kyc.identity.index','profile-verification-with-id.create'],'active') }}"
               href="{{ route('kyc.identity.index') }}">{{ __('ID Verification') }}</a>
        </li>
    </ul>
</div>
