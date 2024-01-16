<?php

namespace App\Http\Controllers\Web\Dispute;

use App\Http\Controllers\Controller;
use App\Models\User\Auction;
use App\Models\User\Dispute;
use App\Models\User\Seller;
use App\Services\Core\DataTableService;
use Carbon\Carbon;

class AdminDisputeController extends Controller
{

    public function index($type = null)
    {
        $conditions = [];
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
            ['disputes.report_type', __('Dispute Type'), dispute_type()],
            ['disputes.status', __('Dispute Type'), dispute_status()],
        ];

        $queryBuilder = Dispute::where($conditions)->orderBy('id', 'desc');
        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filters)
            ->create($queryBuilder);

        $data['title'] = 'All Disputes';
        $data['routeName'] = 'admin-dispute.index';
        $data['carbon'] = new Carbon();

        return view('auction.dispute.index', $data);
    }

    public function edit($id)
    {
        $data['dispute'] = Dispute::where('id', $id)
            ->first();
        $data['title'] = __('Dispute Details');

        if ($data['dispute']->dispute_type == DISPUTE_TYPE_AUCTION_ISSUE) {
            $data['disputed_link'] = Auction::where('ref_id', $data['dispute']->ref_id)->first();
        } else {
            $data['disputed_link'] = Seller::where('ref_id', $data['dispute']->ref_id)->first();
        }

        return view('auction.dispute.edit', $data);
    }

    public function changeDisputeStatus($id)
    {

        $dispute = Dispute::where('id', $id)->first();
        if (empty($dispute)) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to update status'));
        }
        if ($dispute->dispute_status == DISPUTE_STATUS_PENDING) {
            $parameters['dispute_status'] = DISPUTE_STATUS_ON_INVESTIGATION;
        } else {
            $parameters['dispute_status'] = DISPUTE_STATUS_SOLVED;
        }

        if (!Dispute::where('id', $id)->first()->update($parameters)) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to update status'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('Status has been updated successfully'));
    }



    public function declineDispute($id)
    {
        $disputeUpdated = Dispute::where('id', $id)
            ->where('dispute_status', '!=', DISPUTE_STATUS_SOLVED)
            ->update(['dispute_status' => DISPUTE_STATUS_DECLINED]);

        if( $disputeUpdated ) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('The dispute has been declined successfully.'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to update the dispute.'));
    }

    public function markAsRead(Dispute $dispute)
    {
        if ($dispute->markAsRead()) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('This Dispute has been marked as read.'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to mark as read.'));
    }

    public function markAsUnread(Dispute $dispute)
    {
        if ($dispute->markAsUnread()) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('This Dispute has been marked as unread.'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to mark as unread.'));
    }
}
