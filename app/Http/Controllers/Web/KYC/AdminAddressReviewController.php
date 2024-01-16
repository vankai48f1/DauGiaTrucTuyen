<?php

namespace App\Http\Controllers\Web\KYC;

use App\Http\Controllers\Controller;
use App\Models\Core\Notification;
use App\Models\Core\User;
use App\Models\User\KnowYourCustomer;
use App\Services\Core\DataTableService;
use Illuminate\Support\Facades\DB;

class AdminAddressReviewController extends Controller
{
    public function index()
    {
        $filterFields = [
            ['identification_type', __('Identification Type'), identification_type_with_address()],
            ['status', __('Status'), verification_status()],
        ];
        $searchFields = [
            ['name', __('Name'), 'address'],
            ['address', __('Address'), 'address'],
            ['phone_number', __('Phone Number'), 'address'],
            ['post_code', __('Post Code'), 'address'],
            ['city', __('City'), 'address'],
        ];
        $orderFields = [
            ['name', __('Name'), 'address'],
            ['identification_type', __('Identification Type')],
            ['status', __('Status')],
            ['created_at', __('Date')],
        ];

        $queryBuilder = KnowYourCustomer::query()
            ->with('address')
            ->where('verification_type', VERIFICATION_TYPE_ADDRESS)
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setFilterFields($filterFields)
            ->setOrderFields($orderFields)
            ->create($queryBuilder);
        $data['title'] = __('Review Address Verification Request');

        return view('kyc.admin.address_review.index', $data);
    }

    public function show($id)
    {
        $data['verification'] = KnowYourCustomer::where('id', $id)
            ->where('verification_type', VERIFICATION_TYPE_ADDRESS)
            ->with('address.ownerable')
            ->firstOrFail();
        $data['title'] = __('Review Address Verification');

        return view('kyc.admin.address_review.show', $data);
    }

    public function destroy($id)
    {
        $verification = KnowYourCustomer::where('id', $id)
            ->where('verification_type', VERIFICATION_TYPE_ADDRESS)
            ->with('address.ownerable')
            ->first();

        DB::beginTransaction();

        if ($verification) {
            $verification->address->is_verified = VERIFICATION_STATUS_UNVERIFIED;
            $verification->address->update();

            $user = new User();

            if ($verification->address->ownerable instanceof $user) {
                $verification->address->ownerable->is_address_verified = INACTIVE;
                $verification->address->ownerable->update();
            }

            Notification::create([
                'user_id' => $verification->user_id,
                'message' => __("Your recent address verification request has been declined for inappropriate/mismatch information."),
            ]);

            $verification->delete();

            DB::commit();

            return redirect()
                ->route('kyc.admin.address-review.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('The address verification request has been declined successfully.'));
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to decline the address verification request.'));
    }

    public function approve($id)
    {
        $verification = KnowYourCustomer::where('id', $id)
            ->where('verification_type', VERIFICATION_TYPE_ADDRESS)
            ->where('status', VERIFICATION_STATUS_PENDING)
            ->with('address.ownerable')
            ->first();

        DB::beginTransaction();

        if ($verification) {
            $verification->status = VERIFICATION_STATUS_APPROVED;
            $verification->update();

            $verification->address->is_verified = VERIFICATION_STATUS_APPROVED;
            $verification->address->update();

            $user = new User();

            $verification->address->ownerable instanceof $user ?
                $verification->address->ownerable->is_address_verified = ACTIVE :
                $verification->address->ownerable->is_active = ACTIVE;

            $verification->address->ownerable->update();

            Notification::create([
                'user_id' => $verification->user_id,
                'message' => __("Your recent address verification request has been approved."),
            ]);

            DB::commit();

            return redirect()
                ->route('kyc.admin.address-review.show', $verification->id)
                ->with(RESPONSE_TYPE_SUCCESS, __('The address verification request has been approved successfully.'));
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to approve the address verification request.'));
    }
}
