<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auction\CategoryRequest;
use App\Models\Auction\Category;
use App\Services\Core\DataTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminCategoryController extends Controller
{

    public function index()
    {
        $searchFields = [
            ['name', __('Name')],
        ];
        $orderFields = [
            ['name', __('Name')],
        ];

        $queryBuilder = Category::query()
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->withoutDateFilter()
            ->create($queryBuilder);

        $data['title'] = 'Category List';
        return view('auction.category.index', $data);
    }


    public function create()
    {
        $data['title'] = __('Create category');
        return view('auction.category.create', $data);
    }


    public function store(CategoryRequest $request)
    {
        $parameters = $request->validated();

        if (Category::create($parameters)) {
            return redirect()
                ->route('admin.categories.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('Category has been created successfully'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to create category'));
    }


    public function edit(Category $category): View
    {
        $data['category'] = $category;
        $data['title'] = __('Update category');

        return view('auction.category.edit', $data);
    }


    public function update(CategoryRequest $request, Category $category)
    {
        $parameters = $request->validated();

        if ($category->update($parameters)) {
            return redirect()
                ->route('admin.categories.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('Category has been updated successfully'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to update category'));
    }

    public function destroy(Category $category): RedirectResponse
    {

        $auctionCount = $category->auctions()->count();

        if (!$auctionCount && $category->delete()) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('Category has been deleted successfully.'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to delete this category'));
    }
}
