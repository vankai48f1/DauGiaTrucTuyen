<div class="common-nav">
    <ul class="nav nav-tabs" id="profileTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ is_current_route(['store-management.index','seller.store.edit'],'active') }}"
               href="{{ route('seller.store.edit') }}">{{ __('Store Information') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ is_current_route([
            'kyc.seller.addresses.index',
             'kyc.seller.addresses.show',
              'kyc.seller.addresses.create',
              'kyc.seller.addresses.edit',
              'kyc.seller.addresses.verification.create',
              'kyc.seller.addresses.verification.store',
              'kyc.seller.addresses.verification.show'
        ], 'active') }}" href="{{ route('kyc.seller.addresses.index') }}">{{ __('My Store Addresses') }}</a>
        </li>
    </ul>
</div>
