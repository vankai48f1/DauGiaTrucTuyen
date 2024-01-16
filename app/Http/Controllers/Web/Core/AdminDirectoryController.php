<?php

namespace App\Http\Controllers\Web\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\DirectoryRequest;
use App\Services\Core\MediaService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminDirectoryController extends Controller
{
    private $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function store(DirectoryRequest $request)
    {
        if ($this->mediaService->isDirectoryExists($request->get('name'))) {
            throw ValidationException::withMessages(['name' => __('The name already exists')]);
        }

        if ($this->mediaService->makeDirectory($request->get('name'))) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('The directory has been created successfully'));
        }
        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to create directory'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'path' => 'required|max:255',
            'old_name' => 'required|max:255',
        ]);

        if (!$this->mediaService->isDirectoryExists($request->get('old_name'))) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('The directory dose not exists'));
        }
        if ($this->mediaService->isDirectoryExists($request->get('name'))) {
            throw ValidationException::withMessages(['name' => __('The name already exists')]);
        }
        if ($this->mediaService->renameDirectory($request->get('old_name'), $request->get('name'))) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('The directory has been renamed successfully'));
        }
        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to rename directory'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'path' => 'required|max:255',
        ]);
        if (!$this->mediaService->isDirectoryExists($request->get('name'))) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('The directory dose not exists'));
        }
        if ($this->mediaService->deleteDirectory($request->get('name'))) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('The directory has been deleted successfully'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to delete directory'));
    }
}
