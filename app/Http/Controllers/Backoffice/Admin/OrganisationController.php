<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Organisation\UpdateOrganisationRequest;
use App\Http\Requests\Organisation\StoreOrganisationRequest;
use App\Http\Requests\Organisation\StoreAddMerchantRequest;
use App\Http\Requests\Organisation\StoreAddManagerRequest;
use App\Http\Requests\Organisation\StoreAddSellerRequest;
use App\Http\Requests\Organisation\StoreAddVendorRequest;
use App\Http\Requests\Organisation\StoreAddShopRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Requests\UpdateLogoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Enums\MediaTypeEnum;
use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Enums\UserRoleEnum;
use App\Events\ToastEvent;
use App\Events\LogEvent;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $q = $request->query('q');

        $query = Organisation::with(['logo', 'merchant.avatar', 'creator.avatar']);

        $organisations = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.index', compact(['organisations', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.organisations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrganisationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOrganisationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $organisation = Auth::user()->createdOrganisations()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
        ]);

        LogEvent::dispatchCreate($organisation, $request, __('general.organisation.created', ['name' => $organisation->name]));

        return redirect(route('admin.organisations.show', [$organisation]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Organisation $organisation
     * @return View
     */
    public function show(Request $request, Organisation $organisation): View
    {
        $q = $request->query('q');

        $organisation->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'shops.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products']);

        $query = $organisation->shops();

        $shops = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.show', compact(['organisation', 'shops', 'q']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Organisation $organisation
     * @return View|RedirectResponse
     */
    public function edit(Organisation $organisation): View|RedirectResponse
    {
        $organisation->load('logo');

        return view('backoffice.admin.organisations.edit', compact('organisation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrganisationRequest $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function update(UpdateOrganisationRequest $request, Organisation $organisation): RedirectResponse
    {
        $validated = $request->validated();

        $organisation->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
        ]);

        LogEvent::dispatchUpdate($organisation, $request, __('general.organisation.updated', ['name' => $organisation->name]));

        return redirect(route('admin.organisations.show', [$organisation]));
    }

    /**
     * Toggle organisation status.
     *
     * @param Request $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Organisation $organisation): RedirectResponse
    {
        $message = $organisation->status_toggle['message'];
        $organisation->update(['status' => $organisation->status_toggle['next']]);

        LogEvent::dispatchUpdate($organisation, $request, $message);

        return back();
    }

    /**
     * Update organisation logo.
     *
     * @param UpdateLogoRequest $request $
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function changeLogo(UpdateLogoRequest $request, Organisation $organisation): RedirectResponse
    {
        $validated = $request->validated();

        $logo = $organisation->logo;

        $logoName = Storage::disk('public')->put(MediaTypeEnum::Logo->value, $validated['logo']);

        if($logoName)
        {
            if($logo)
            {
                $logo->update(['name' => $logoName]);

                LogEvent::dispatchUpdate($organisation, $request, __('general.organisation.logo_updated', ['name' => $organisation->name]));
            }
            else
            {
                $organisation->logo()->create([
                    'name' => $logoName,
                    'type' => MediaTypeEnum::Logo,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($organisation, $request, __('general.organisation.logo_created', ['name' => $organisation->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete organisation logo.
     *
     * @param Request $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function removeLogo(Request $request, Organisation $organisation): RedirectResponse
    {
        $organisation->logo()->delete();

        LogEvent::dispatchDelete($organisation, $request, __('general.organisation.logo_deleted', ['name' => $organisation->name]));

        return back();
    }

    /**
     * Update organisation banner.
     *
     * @param UpdateBannerRequest $request $
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function changeBanner(UpdateBannerRequest $request, Organisation $organisation): RedirectResponse
    {
        $validated = $request->validated();

        $banner = $organisation->banner;

        $bannerName = Storage::disk('public')->put(MediaTypeEnum::Banner->value, $validated['banner']);

        if($bannerName)
        {
            if($banner)
            {
                $banner->update(['name' => $bannerName]);

                LogEvent::dispatchUpdate($organisation, $request, __('general.organisation.banner_updated', ['name' => $organisation->name]));
            }
            else
            {
                $organisation->banner()->create([
                    'name' => $bannerName,
                    'type' => MediaTypeEnum::Banner,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($organisation, $request, __('general.organisation.banner_created', ['name' => $organisation->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete organisation banner.
     *
     * @param Request $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function removeBanner(Request $request, Organisation $organisation): RedirectResponse
    {
        $organisation->banner()->delete();

        LogEvent::dispatchDelete($organisation, $request, __('general.organisation.banner_deleted', ['name' => $organisation->name]));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Organisation $organisation
     * @return View
     */
    public function showLogs(Organisation $organisation): View
    {
        $organisation->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'logs.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products']);

        $logs = $organisation->logs()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.show-logs', compact(['organisation', 'logs']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Organisation $organisation
     * @return View
     */
    public function showVendors(Request $request, Organisation $organisation): View
    {
        $q = $request->query('q');

        $organisation->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'vendors.logo', 'vendors.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products']);

        $query = $organisation->vendors();

        $vendors = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.show-vendors', compact(['organisation', 'vendors', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Organisation $organisation
     * @return View
     */
    public function showUsers(Request $request, Organisation $organisation): View
    {
        $q = $request->query('q');

        $organisation->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'users.avatar', 'users.creator.avatar', 'users.shop'])
            ->loadCount(['shops', 'vendors', 'users', 'products']);

        $query = $organisation->users();
        $users = ($q)
            ? $query->search($q)->orderBy('first_name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.show-users', compact(['organisation', 'users', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Organisation $organisation
     * @return View
     */
    public function showProducts(Request $request, Organisation $organisation): View
    {
        $q = $request->query('q');

        $organisation->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'products.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products']);

        $query = $organisation->products();

        $products = ($q)
            ? $query->search($q)->orderBy('code')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.show-products', compact(['organisation', 'products', 'q']));
    }

    /**
     * Show the form for adding a merchant.
     *
     * @param Organisation $organisation
     * @return View|RedirectResponse
     */
    public function showAddMerchantForm(Organisation $organisation): View|RedirectResponse
    {
        if(!$organisation->can_add_merchant) {
            ToastEvent::dispatchWarning(__('general.permission_denied'));
            return back();
        }

        $organisation->load('logo');

        return view('backoffice.admin.organisations.add-merchant', compact('organisation'));
    }

    /**
     * Add a merchant.
     *
     * @param StoreAddMerchantRequest $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function addMerchant(StoreAddMerchantRequest $request, Organisation $organisation): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $merchant = $organisation->users()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        $merchant->syncRoles([UserRoleEnum::Merchant->value]);

        LogEvent::dispatchCreate($merchant, $request, __('general.user.merchant_created', ['name' => $merchant->full_name]));

        return redirect(route('admin.organisations.show.users', [$organisation]));
    }

    /**
     * Show the form for adding a manager.
     *
     * @param Organisation $organisation
     * @return View|RedirectResponse
     */
    public function showAddManagerForm(Organisation $organisation): View|RedirectResponse
    {
        if(!$organisation->can_add_manager) {
            ToastEvent::dispatchWarning(__('general.permission_denied'));
            return back();
        }

        $organisation->load('logo');

        return view('backoffice.admin.organisations.add-manager', compact('organisation'));
    }

    /**
     * Add a manager.
     *
     * @param StoreAddManagerRequest $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function addManager(StoreAddManagerRequest $request, Organisation $organisation): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $manager = $organisation->users()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'description' => $validated['description'],
            'shop_id' => $validated['shop'],
            'creator_id' => $authUser->id,
        ]);

        $manager->syncRoles([UserRoleEnum::ShopManager->value]);

        LogEvent::dispatchCreate($manager, $request, __('general.user.manager_created', ['name' => $manager->full_name]));

        return redirect(route('admin.organisations.show.users', [$organisation]));
    }

    /**
     * Show the form for adding a seller.
     *
     * @param Organisation $organisation
     * @return View|RedirectResponse
     */
    public function showAddSellerForm(Organisation $organisation): View|RedirectResponse
    {
        $organisation->load('logo');

        return view('backoffice.admin.organisations.add-seller', compact('organisation'));
    }

    /**
     * Add a seller.
     *
     * @param StoreAddSellerRequest $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function addSeller(StoreAddSellerRequest $request, Organisation $organisation): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $seller = $organisation->users()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'description' => $validated['description'],
            'shop_id' => $validated['shop'],
            'creator_id' => $authUser->id,
        ]);

        $seller->syncRoles([UserRoleEnum::Seller->value]);

        LogEvent::dispatchCreate($seller, $request, __('general.user.seller_created', ['name' => $seller->full_name]));

        return redirect(route('admin.organisations.show.users', [$organisation]));
    }

    /**
     * Show the form for adding a state.
     *
     * @param Organisation $organisation
     * @return View
     */
    public function showAddShopForm(Organisation $organisation): View
    {
        $organisation->load('logo');

        return view('backoffice.admin.organisations.add-shop', compact('organisation'));
    }

    /**
     * Add a state.
     *
     * @param StoreAddShopRequest $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function addShop(StoreAddShopRequest $request, Organisation $organisation): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $shop = $organisation->shops()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        LogEvent::dispatchCreate($shop, $request, __('general.shop.created', ['name' => $shop->name]));

        return redirect(route('admin.organisations.show', [$organisation]));
    }

    /**
     * Show the form for adding a vendor.
     *
     * @param Organisation $organisation
     * @return View
     */
    public function showAddVendorForm(Organisation $organisation): View
    {
        $organisation->load('logo');

        return view('backoffice.admin.organisations.add-vendor', compact('organisation'));
    }

    /**
     * Add a vendor.
     *
     * @param StoreAddVendorRequest $request
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function addVendor(StoreAddVendorRequest $request, Organisation $organisation): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $vendor = $organisation->vendors()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        LogEvent::dispatchCreate($vendor, $request, __('general.vendor.created', ['name' => $vendor->name]));

        return redirect(route('admin.organisations.show.vendors', [$organisation]));
    }
}
