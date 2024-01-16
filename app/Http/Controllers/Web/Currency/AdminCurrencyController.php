<?php

namespace App\Http\Controllers\Web\Currency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyRequest;
use App\Models\Auction\Currency;
use App\Services\Core\DataTableService;
use App\Services\Core\FileUploadService;

class AdminCurrencyController extends Controller
{
    public function index()
    {

        $searchFields = [
            ['name', __('Name')],
        ];
        $orderFields = [
            ['name', __('Name')],
        ];

        $queryBuilder = Currency::query()
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->withoutDateFilter()
            ->create($queryBuilder);

        $data['title'] = 'Currency List';

        return view('currency.index', $data);
    }

    public function create()
    {
        $data['title'] = __('Create Currency');

        return view('currency.create', $data);
    }

    public function store(CurrencyRequest $request)
    {
        $parameters = $request->only('name', 'symbol', 'type', 'is_active');

        if ($request->hasfile('logo')) {
            $uploadedImage = app(FileUploadService::class)
                ->upload(
                    $request->file('logo'),
                    config('commonconfig.currency_logo'),
                    'logo',
                    $parameters['symbol'],
                    '',
                    'public',
                    100,
                    100
                );

            if (!empty($uploadedImage)) {
                $parameters['logo'] = $uploadedImage;
            }
        }

        if (Currency::create($parameters)) {
            return redirect()
                ->route('admin.currencies.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('The currency has been created successfully'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to create the currency! Please try again.'));
    }

    public function edit(Currency $currency)
    {
        $data['currency'] = $currency;
        $data['title'] = __('Edit Currency');

        return view('currency.edit', $data);
    }

    public function update(CurrencyRequest $request, Currency $currency)
    {
        $parameters = $request->only('name', 'symbol', 'is_active');

        if ($request->hasFile('logo')) {
            $logoImage = app(FileUploadService::class)
                ->upload(
                    $request->file('logo'),
                    config('commonconfig.currency_logo'),
                    'logo',
                    $currency->symbol,
                    '',
                    'public',
                    100,
                    100
                );

            $parameters['logo'] = $logoImage;
        }

        if ($currency->update($parameters)) {
            return redirect()
                ->route('admin.currencies.edit', $currency->symbol)
                ->with(RESPONSE_TYPE_SUCCESS, __('The currency has been updated successfully'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to update the currency! Please try again.'));
    }
}
