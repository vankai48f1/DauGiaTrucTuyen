<?php

namespace App\Http\Controllers\Web\KYC;

use App\Http\Controllers\Controller;
use App\Models\Core\Notification;
use App\Models\User\KnowYourCustomer;
use App\Services\Core\DataTableService;
use Illuminate\Support\Facades\DB;

class AdminIdentityReviewController extends Controller
{
    public function index()
    {
        $filterFields = [
            ['identification_type', __('Identification Type'), identification_type_with_id()],
            ['status', __('Status'), verification_status()],
        ];
        $orderFields = [
            ['identification_type', __('Identification Type')],
            ['status', __('Status')],
            ['created_at', __('Date')],
        ];

        $queryBuilder = KnowYourCustomer::query()
            ->with('user.profile')
            ->where('verification_type', VERIFICATION_TYPE_ID)
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setFilterFields($filterFields)
            ->setOrderFields($orderFields)
            ->create($queryBuilder);
        $data['title'] = __('Review Identity Verification Request');

        return view('kyc.admin.identity_review.index', $data);
    }

    public function show($id)
    {
        $data['verification'] = KnowYourCustomer::where('id', $id)
            ->where('verification_type', VERIFICATION_TYPE_ID)
            ->with('user')
            ->firstOrFail();
        $data['title'] = __('Review Identity Verification Request');

        return view('kyc.admin.identity_review.show', $data);
    }

    public function destroy($id)
    {
        $verification = KnowYourCustomer::where('id', $id)
            ->where('verification_type', VERIFICATION_TYPE_ID)
            ->with('user')
            ->first();

        DB::beginTransaction();

        if ($verification) {
            $verification->user->is_id_verified = VERIFICATION_STATUS_UNVERIFIED;
            $verification->user->update();

            Notification::create([
                'user_id' => $verification->user_id,
                'message' => __("Your recent Identity verification request has been declined for inappropriate/mismatch information."),
            ]);

            $verification->delete();

            DB::commit();

            return redirect()
                ->route('kyc.admin.identity-review.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('The identity verification request has been declined successfully.'));
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to decline the identity verification request.'));
    }

    public function approve($id)
    {
        $verification = KnowYourCustomer::where('id', $id)
            ->where('verification_type', VERIFICATION_TYPE_ID)
            ->where('status', VERIFICATION_STATUS_PENDING)
            ->with('user')
            ->first();

        DB::beginTransaction();

        if ($verification) {
            $verification->status = VERIFICATION_STATUS_APPROVED;
            $verification->update();

            $verification->user->is_id_verified = ACTIVE;
            $verification->user->update();

            Notification::create([
                'user_id' => $verification->user_id,
                'message' => __("Your recent identity verification request has been approved."),
            ]);

            DB::commit();

            return redirect()
                ->route('kyc.admin.identity-review.show', $verification->id)
                ->with(RESPONSE_TYPE_SUCCESS, __('The identity verification request has been approved successfully.'));
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to approve the address verification request.'));
    }
}
