<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use App\Enums\GeneralStatusEnum;
use App\Enums\MediaTypeEnum;
use Illuminate\Http\Request;
use App\Events\ToastEvent;
use App\Events\LogEvent;
use App\Models\Category;

class VendorController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('allow:super,admin')->only([
            'edit', 'update', 'statusToggle', 'changeBanner', 'removeBanner'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $q = $request->query('q');

        $query = Category::with(['banner', 'creator.avatar']);

        $categories = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.categories.index', compact(['categories', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $category = $authUser->createdCategories()->create([
            'status' => $status,
            'name' => $validated['name'], 
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
            'group_id' => $validated['group'],
        ]);

        LogEvent::dispatchCreate($category, $request, __('general.category.created', ['name' => $category->name]));

        return redirect(route('admin.categories.show', [$category]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Category $category
     * @return View
     */
    public function show(Request $request, Category $category): View
    {
        $q = $request->query('q');

        $category->load(['banner', 'tags', 'creator.avatar', 'products.creator.avatar'])
            ->loadCount('products');

        $query = $category->products();

        $products = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.categories.show', compact(['category', 'products', 'q']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        $category->load('banner');

        return view('backoffice.admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
            'group_id' => $validated['group'],
        ]);

        LogEvent::dispatchUpdate($category, $request, __('general.category.updated', ['name' => $category->name]));

        return redirect(route('admin.categories.show', [$category]));
    }

    /**
     * Toggle category status.
     *
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Category $category): RedirectResponse
    {
        $message = $category->status_toggle['message'];
        $category->update(['status' => $category->status_toggle['next']]);

        LogEvent::dispatchUpdate($category, $request, $message);

        return back();
    }

    /**
     * Update category banner.
     *
     * @param UpdateBannerRequest $request $
     * @param Category $category
     * @return RedirectResponse
     */
    public function changeBanner(UpdateBannerRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        $banner = $category->banner;

        $bannerName = Storage::disk('public')->put(MediaTypeEnum::Banner->value, $validated['banner']);

        if($bannerName)
        {
            if($banner)
            {
                $banner->update(['name' => $bannerName]);

                LogEvent::dispatchUpdate($category, $request, __('general.category.banner_updated', ['name' => $category->name]));
            }
            else
            {
                $category->banner()->create([
                    'name' => $bannerName,
                    'type' => MediaTypeEnum::Banner,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($category, $request, __('general.category.banner_created', ['name' => $category->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete category banner.
     *
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function removeBanner(Request $request, Category $category): RedirectResponse
    {
        $category->banner()->delete();

        LogEvent::dispatchDelete($category, $request, __('general.category.banner_deleted', ['name' => $category->name]));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return View
     */
    public function showLogs(Category $category): View
    {
        $category->load(['banner', 'tags', 'creator.avatar', 'logs.creator.avatar'])
            ->loadCount('products');

        $logs = $category->logs()->orderBy('created_at', 'desc')->paginate();
//dd($logs);
        return view('backoffice.admin.categories.show-logs', compact(['category', 'logs']));
    }
}
