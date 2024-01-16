@component('components.card',['type' => 'info'])
    <img src="{{ get_avatar($user->avatar) }}" alt="{{ __('Profile Image') }}" class="img-rounded img-fluid">
    <h5 class="text-bold mt-3 mb-0 text-lg text-center">{{ $user->profile->full_name }}</h5>
@endcomponent
