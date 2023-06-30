<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\UpdateLogoRequest;
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
use App\Models\Brand;

class BrandController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('allow:super,admin')->only([
            'edit', 'update', 'statusToggle', 'changeLogo', 'removeLogo'
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

        $query = Brand::with(['logo', 'creator.avatar']);

        $brands = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.brands.index', compact(['brands', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBrandRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $brand = $authUser->createdBrands()->create([
            'status' => $status,
            'name' => $validated['name'],
            'website' => $validated['website'],
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
        ]);

        LogEvent::dispatchCreate($brand, $request, __('general.brand.created', ['name' => $brand->name]));

        return redirect(route('admin.brands.show', [$brand]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Brand $brand
     * @return View
     */
    public function show(Request $request, Brand $brand): View
    {
        $q = $request->query('q');

        $brand->load(['logo', 'creator.avatar', 'products.creator.avatar'])->loadCount('products');

        $query = $brand->products();

        $products = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.brands.show', compact(['brand', 'products', 'q']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Brand $brand
     * @return View
     */
    public function edit(Brand $brand): View
    {
        $brand->load('logo');

        return view('backoffice.admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBrandRequest $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $validated = $request->validated();

        $brand->update([
            'name' => $validated['name'],
            'website' => $validated['website'],
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
        ]);

        LogEvent::dispatchUpdate($brand, $request, __('general.brand.updated', ['name' => $brand->name]));

        return redirect(route('admin.brands.show', [$brand]));
    }

    /**
     * Toggle brand status.
     *
     * @param Request $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Brand $brand): RedirectResponse
    {
        $message = $brand->status_toggle['message'];
        $brand->update(['status' => $brand->status_toggle['next']]);

        LogEvent::dispatchUpdate($brand, $request, $message);

        return back();
    }

    /**
     * Update brand logo.
     *
     * @param UpdateLogoRequest $request $
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function changeLogo(UpdateLogoRequest $request, Brand $brand): RedirectResponse
    {
        $validated = $request->validated();

        $logo = $brand->logo;

        $logoName = Storage::disk('public')->put(MediaTypeEnum::Logo->value, $validated['logo']);

        if($logoName)
        {
            if($logo)
            {
                $logo->update(['name' => $logoName]);

                LogEvent::dispatchUpdate($brand, $request, __('general.brand.logo_updated', ['name' => $brand->name]));
            }
            else
            {
                $brand->logo()->create([
                    'name' => $logoName,
                    'type' => MediaTypeEnum::Logo,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($brand, $request, __('general.brand.logo_created', ['name' => $brand->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete brand logo.
     *
     * @param Request $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function removeLogo(Request $request, Brand $brand): RedirectResponse
    {
        $brand->logo()->delete();

        LogEvent::dispatchDelete($brand, $request, __('general.brand.logo_deleted', ['name' => $brand->name]));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Brand $brand
     * @return View
     */
    public function showLogs(Brand $brand): View
    {
        $brand->load(['logo', 'creator.avatar', 'logs.creator.avatar'])->loadCount('products');

        $logs = $brand->logs()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.brands.show-logs', compact(['brand', 'logs']));
    }
}
