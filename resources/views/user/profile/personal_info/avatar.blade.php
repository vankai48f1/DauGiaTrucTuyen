@component('components.card',['type' => 'info'])
    <img src="{{ get_avatar(auth()->user()->avatar) }}" alt="{{ __('Profile Image') }}" class="img-rounded img-fluid">
    <p class="text-bold mt-2 text-lg text-center font-weight-bold">{{ auth()->user()->profile->full_name }}</p>
    <a class="btn bg-custom-gray fz-14 d-inline-block mt-2 color-666 w-100 {{ is_current_route('profile.avatar.edit','active') }}" href="{{ route('profile.avatar.edit') }}">{{ __('Change Avatar') }}</a>
@endcomponent
