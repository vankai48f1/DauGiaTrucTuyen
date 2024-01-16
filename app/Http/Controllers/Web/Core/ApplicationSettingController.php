<?php

namespace App\Http\Controllers\Web\Core;

use App\Http\Controllers\Controller;
use App\Services\Core\ApplicationSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationSettingController extends Controller
{
    public $applicationSettingService;

    public function __construct(ApplicationSettingService $applicationSettingService)
    {
        $this->applicationSettingService = $applicationSettingService;
    }

    public function index(): RedirectResponse
    {
        $type = array_key_first($this->applicationSettingService->settingsConfigurations);
        $sub_type = array_key_first(current($this->applicationSettingService->settingsConfigurations)['sub-settings']);
        return redirect()->route('application-settings.edit', ['type' => $type, 'sub_type' => $sub_type]);
    }

    public function edit(string $type, string $sub_type): View
    {
        abort_if(!isset($this->applicationSettingService->settingsConfigurations[$type]['sub-settings'][$sub_type]), 404);

        $data['settings'] = $this->applicationSettingService->loadForm($type, $sub_type);
        $data['type'] = $type;
        $data['sub_type'] = $sub_type;
        $data['title'] = __('Edit - :type Settings', ['type' => ucfirst($type)]);
        return view('core.application_settings.edit', $data);
    }

    public function update(Request $request, string $type, string $sub_type): RedirectResponse
    {
        if (!isset($this->applicationSettingService->settingsConfigurations[$type]['sub-settings'][$sub_type])) {
            return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed to update settings.'));
        }

        $response = $this->applicationSettingService->update($request, $type, $sub_type);
        $status = $response[RESPONSE_STATUS_KEY] ? RESPONSE_TYPE_SUCCESS : RESPONSE_TYPE_ERROR;

        return redirect()->route('application-settings.edit', [$type, $sub_type])->withInput($response['inputs'])->withErrors($response['errors'])->with($status, $response[RESPONSE_MESSAGE_KEY]);
    }
}
