@component('components.table', ['class' => 'table-borderless table-striped table-sm mt-5'])
    <tr>
        <td class="col-6"><i class="mr-1 fa fa-user"></i> {{__('Name')}}
        </td>
        <td class="col-6">{{$address->name}}</td>
    </tr>
    <tr>
        <td class="col-6"><i
                class="mr-1 fa fa-address-card-o"></i> {{__('Location')}}
        </td>
        <td class="col-6">{{$address->city}} {{$address->country->name}}</td>
    </tr>
    <tr>
        <td class="col-6"><i class="mr-1 fa fa-phone"></i> {{__('Phone')}}
        </td>
        <td class="col-6">{{$address->phone_number}}</td>
    </tr>
    <tr>
        <td class="col-6"><i
                class="mr-1 fa fa-location-arrow"></i> {{__('Post Code')}}
        </td>
        <td class="col-6">{{$address->post_code}}</td>
    </tr>
    <tr>
        <td class="col-6"><i class="mr-1 fa fa-check-circle"></i> {{__('Verification Status')}}</td>
        <td class="col-6">
            <span class="badge badge-{{config('commonconfig.verification_status.' . $address->is_verified . '.color_class')}}">{{verification_status($address->is_verified)}}</span>
        </td>
    </tr>
@endcomponent
