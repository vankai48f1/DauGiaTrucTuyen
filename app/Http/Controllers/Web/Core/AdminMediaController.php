<?php

namespace App\Http\Controllers\Web\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\MediumRequest;
use App\Models\Core\Medium;
use App\Services\Core\DataTableService;
use App\Services\Core\MediaService;
use App\Services\Logger\Logger;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminMediaController extends Controller
{
    private $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $searchFields = [
            ['name', __('Name')],
        ];

        $orderFields = [
            ['name', __('Name')],
            ['created_at', __('Created At')],
        ];

        $data['pathInfo'] = [
            'currentPath' => $this->mediaService->getCurrentPath(),
            'upLevelPath' => $this->mediaService->getUpLevelPath(),
        ];
        $data['directories'] = $this->mediaService->getDirectories();
        $queryBuilder = Medium::where('path', $this->mediaService->getCurrentPath())->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->create($queryBuilder);

        $data['title'] = __('Media List');

        return view('core.media.index', $data);
    }

    public function store(MediumRequest $request)
    {
        $params['id'] = Str::uuid()->toString();
        $params['path'] = $request->get('path');
        $params['file_name'] = $this->mediaService->upload($request->file('file'), $params['id']);

        if (empty($params['file_name'])) {
            return response()
                ->json([
                    RESPONSE_STATUS_KEY => false,
                    RESPONSE_MESSAGE_KEY => __('Failed to upload file.')
                ], 400);
        }
        $params['name'] = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
        $params['disk'] = $this->mediaService->getDisk();
        $params['mime_type'] = $request->file('file')->getClientMimeType();
        $params['created_at'] = now();
        $params['updated_at'] = now();

        if (Medium::insert($params)) {
            return response()->json([
                RESPONSE_STATUS_KEY => true,
                RESPONSE_MESSAGE_KEY => __('File has been uploaded successfully.'),
                RESPONSE_DATA_KEY => [
                    'html' => view('core.media.image', [
                        'mediaId' => $params['id'],
                        'mediaName' => $params['name'],
                        'mediaPath' => get_media_file($params['path'],
                            $params['file_name'])
                    ])->render(),
                ]
            ]);
        }
        return response()->json([RESPONSE_STATUS_KEY => false, RESPONSE_MESSAGE_KEY => __('Failed to upload file.')], 400);
    }

    public function destroy(Medium $medium)
    {
        try {
            DB::beginTransaction();
            if (!$medium->delete()) {
                throw new Exception('Failed to delete medium');
            }

            if (!$this->mediaService->remove($medium->path, $medium->file_name)) {
                throw new Exception('Failed to remove file from disk');
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Logger::error($exception, "[FAILED][AdminMediaController][destroy]");
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to delete image'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('The image has been deleted successfully'));
    }
}
