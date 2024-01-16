<?php

namespace App\Http\Controllers\Web\Dispute;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DisputeRequest;
use App\Models\User\Auction;
use App\Models\User\Dispute;
use App\Models\User\Seller;
use App\Services\Core\DataTableService;
use App\Services\Core\FileUploadService;
use Carbon\Carbon;

class UserDisputeController extends Controller
{

    public function index($type = null)
    {
        $conditions = [
            'user_id' => auth()->user()->id,
        ];
        if (!is_null($type)) {
            $conditions['dispute_type'] = $type;
        }

        $searchFields = [
            ['title', __('Dispute Title')],
            ['report_type', __('Dispute Type')],
            ['description', __('Description')],
        ];
        $orderFields = [
            ['report_type', __('Dispute Type')],
            ['title', __('Title')],
            ['id', __('Id')],
        ];

        $filters = [
            ['disputes.report_type', __('Auction Type'), dispute_type()],
        ];

        $queryBuilder = Dispute::where($conditions)->orderBy('id', 'desc');
        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filters)
            ->create($queryBuilder);

        $data['title'] = 'All Disputes';
        $data['routeName'] = 'dispute.index';
        $data['carbon'] = new Carbon();

        return view('dispute.index', $data);
    }

    public function specific($disputeType, $refId)
    {
        return $this->create($disputeType, $refId);

    }

    public function create($disputeType = null, $refId = null)
    {
        $data['disputeType'] = $disputeType;
        $data['refId'] = $refId;
        $data['title'] = __('Create Report');

        return view('dispute._form_dispute', $data);
    }

    public function store(DisputeRequest $request)
    {
        $parameters = $request->validated();
        $parameters['user_id'] = auth()->id();
        $parameters['dispute_status'] = DISPUTE_STATUS_PENDING;

        if (in_array($parameters['dispute_type'], [DISPUTE_TYPE_AUCTION_ISSUE, DISPUTE_TYPE_SELLER_ISSUE, DISPUTE_TYPE_SHIPPING_ISSUE])) {

            if ($parameters['dispute_type'] == DISPUTE_TYPE_AUCTION_ISSUE) {
                $data = Auction::where('ref_id', $request->ref_id)->first();
                if (!$data) {
                    return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Reference ID does not match'));
                }
            } elseif ($parameters['dispute_type'] == DISPUTE_TYPE_SELLER_ISSUE) {
                $data = Seller::where('ref_id', $request->ref_id)->first();
                if (!$data) {
                    return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Reference ID does not match'));
                }
            } else {
                $data = Auction::where('ref_id', $request->ref_id)->first();
                if (!$data) {
                    return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Reference ID does not match'));
                }

                $para['product_claim_status'] = AUCTION_PRODUCT_CLAIM_STATUS_DISPUTED;
                Auction::where('id', $data->id)->update($para);
            }
            if (!$data) {
                return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed To Dispute.'));
            }
            $parameters['ref_id'] = $data->ref_id;
            $parameters['model'] = get_class($data);
        }

        $new_name = 0;
        if ($request->hasfile('images')) {
            $uploadedImage = [];
            foreach ($request->images as $files) {
                $uploadedImage[] = app(FileUploadService::class)->upload($files, config('commonconfig.dispute_image'), 'images', '', $new_name++, 'public', 400, 400);
            }

            if (!empty($uploadedImage)) {
                $parameters['images'] = $uploadedImage;
            }
        }

        if (Dispute::create($parameters)) {

            return redirect()->route('dispute.index')->with(RESPONSE_TYPE_SUCCESS, __('Dispute has been submitted.'));

        }

        return redirect()->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed To Dispute.'));

    }

}
