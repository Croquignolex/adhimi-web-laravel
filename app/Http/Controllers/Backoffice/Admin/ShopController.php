<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Shop\StoreAddManagerRequest;
use App\Http\Requests\Shop\StoreAddSellerRequest;
use App\Http\Requests\Shop\UpdateShopRequest;
use App\Http\Requests\Shop\StoreShopRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Requests\UpdateLogoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Enums\MediaTypeEnum;
use Illuminate\Http\Request;
use App\Enums\UserRoleEnum;
use App\Events\ToastEvent;
use App\Events\LogEvent;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('allow:super,admin')->only([
            'edit', 'update', 'statusToggle'
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

        $query = Shop::with(['organisation.logo', 'manager.avatar', 'creator.avatar']);

        $shops = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.index', compact(['shops', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreShopRequest $request
     * @return RedirectResponse
     */
    public function store(StoreShopRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $shop = Auth::user()->createdShops()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'organisation_id' => $validated['organisation'],
        ]);

        LogEvent::dispatchCreate($shop, $request, __('general.shop.created', ['name' => $shop->name]));

        return redirect(route('admin.shops.show', [$shop]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Shop $shop
     * @return View
     */
    public function show(Request $request, Shop $shop): View
    {
        $q = $request->query('q');

        $shop->load(['organisation.logo', 'manager.avatar', 'creator.avatar', 'users.creator.avatar'])
            ->loadCount('users');

        $query = $shop->users();

        $users = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.show', compact(['shop', 'users', 'q']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Shop $shop
     * @return View|RedirectResponse
     */
    public function edit(Shop $shop): View|RedirectResponse
    {
        return view('backoffice.admin.shops.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateShopRequest $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function update(UpdateShopRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $shop->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'phone' => $validated['phone'],
            'description' => $validated['description']
        ]);

        LogEvent::dispatchUpdate($shop, $request, __('general.shop.updated', ['name' => $shop->name]));

        return redirect(route('admin.shops.show', [$shop]));
    }

    /**
     * Toggle shop status.
     *
     * @param Request $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Shop $shop): RedirectResponse
    {
        $message = $shop->status_toggle['message'];
        $shop->update(['status' => $shop->status_toggle['next']]);

        LogEvent::dispatchUpdate($shop, $request, $message);

        return back();
    }

    /**
     * Update shop logo.
     *
     * @param UpdateLogoRequest $request $
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function changeLogo(UpdateLogoRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $logo = $shop->logo;

        $logoName = Storage::disk('public')->put(MediaTypeEnum::Banner->value, $validated['logo']);

        if($logoName)
        {
            if($logo)
            {
                $logo->update(['name' => $logoName]);

                LogEvent::dispatchUpdate($shop, $request, __('general.shop.logo_updated', ['name' => $shop->name]));
            }
            else
            {
                $shop->logo()->create([
                    'name' => $logoName,
                    'type' => MediaTypeEnum::Logo,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($shop, $request, __('general.shop.logo_created', ['name' => $shop->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete shop logo.
     *
     * @param Request $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function removeLogo(Request $request, Shop $shop): RedirectResponse
    {
        $shop->logo()->delete();

        LogEvent::dispatchDelete($shop, $request, __('general.shop.logo_deleted', ['name' => $shop->name]));

        return back();
    }

    /**
     * Update shop banner.
     *
     * @param UpdateBannerRequest $request $
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function changeBanner(UpdateBannerRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $banner = $shop->banner;

        $bannerName = Storage::disk('public')->put(MediaTypeEnum::Banner->value, $validated['banner']);

        if($bannerName)
        {
            if($banner)
            {
                $banner->update(['name' => $bannerName]);

                LogEvent::dispatchUpdate($shop, $request, __('general.shop.banner_updated', ['name' => $shop->name]));
            }
            else
            {
                $shop->banner()->create([
                    'name' => $bannerName,
                    'type' => MediaTypeEnum::Banner,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($shop, $request, __('general.shop.banner_created', ['name' => $shop->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete shop banner.
     *
     * @param Request $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function removeBanner(Request $request, Shop $shop): RedirectResponse
    {
        $shop->banner()->delete();

        LogEvent::dispatchDelete($shop, $request, __('general.shop.banner_deleted', ['name' => $shop->name]));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Shop $shop
     * @return View
     */
    public function showLogs(Shop $shop): View
    {
        $shop->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'logs.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products', 'coupons']);

        $logs = $shop->logs()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.show-logs', compact(['shop', 'logs']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Shop $shop
     * @return View
     */
    public function showVendors(Request $request, Shop $shop): View
    {
        $q = $request->query('q');

        $shop->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'vendors.logo', 'vendors.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products', 'coupons']);

        $query = $shop->vendors();

        $vendors = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.show-vendors', compact(['shop', 'vendors', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Shop $shop
     * @return View
     */
    public function showUsers(Request $request, Shop $shop): View
    {
        $q = $request->query('q');

        $shop->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'users.avatar', 'users.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products', 'coupons']);

        $query = $shop->users();
        $users = ($q)
            ? $query->search($q)->orderBy('first_name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.show-users', compact(['shop', 'users', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Shop $shop
     * @return View
     */
    public function showCoupons(Request $request, Shop $shop): View
    {
        $q = $request->query('q');

        $shop->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'coupons.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products', 'coupons']);

        $query = $shop->coupons();

        $coupons = ($q)
            ? $query->search($q)->orderBy('code')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.show-coupons', compact(['shop', 'coupons', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Shop $shop
     * @return View
     */
    public function showProducts(Request $request, Shop $shop): View
    {
        $q = $request->query('q');

        $shop->load(['logo', 'banner', 'creator.avatar', 'merchant.avatar', 'products.creator.avatar'])
            ->loadCount(['shops', 'vendors', 'users', 'products', 'coupons']);

        $query = $shop->coupons();

        $products = ($q)
            ? $query->search($q)->orderBy('code')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.show-products', compact(['shop', 'products', 'q']));
    }

    /**
     * Show the form for adding a merchant.
     *
     * @param Shop $shop
     * @return View|RedirectResponse
     */
    public function showAddMerchantForm(Shop $shop): View|RedirectResponse
    {
        if(!$shop->can_add_merchant) {
            ToastEvent::dispatchWarning(__('general.permission_denied'));
            return back();
        }

        $shop->load('logo');

        return view('backoffice.admin.shops.add-merchant', compact('shop'));
    }

    /**
     * Add a merchant.
     *
     * @param StoreAddMerchantRequest $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function addMerchant(StoreAddMerchantRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $merchant = $shop->users()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'profession' => $validated['profession'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        $merchant->syncRoles([UserRoleEnum::Merchant->value]);

        LogEvent::dispatchCreate($merchant, $request, __('general.user.merchant_created', ['name' => $merchant->full_name]));

        return redirect(route('admin.shops.show.users', [$shop]));
    }

    /**
     * Show the form for adding a manager.
     *
     * @param Shop $shop
     * @return View|RedirectResponse
     */
    public function showAddManagerForm(Shop $shop): View|RedirectResponse
    {
        if(!$shop->can_add_manager) {
            ToastEvent::dispatchWarning(__('general.permission_denied'));
            return back();
        }

        $shop->load('logo');

        return view('backoffice.admin.shops.add-manager', compact('shop'));
    }

    /**
     * Add a manager.
     *
     * @param StoreAddManagerRequest $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function addManager(StoreAddManagerRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $manager = $shop->users()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'profession' => $validated['profession'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'description' => $validated['description'],
            'shop_id' => $validated['shop'],
            'creator_id' => $authUser->id,
        ]);

        $manager->syncRoles([UserRoleEnum::ShopManager->value]);

        LogEvent::dispatchCreate($manager, $request, __('general.user.manager_created', ['name' => $manager->full_name]));

        return redirect(route('admin.shops.show.users', [$shop]));
    }

    /**
     * Show the form for adding a seller.
     *
     * @param Shop $shop
     * @return View|RedirectResponse
     */
    public function showAddSellerForm(Shop $shop): View|RedirectResponse
    {
        $shop->load('logo');

        return view('backoffice.admin.shops.add-seller', compact('shop'));
    }

    /**
     * Add a seller.
     *
     * @param StoreAddSellerRequest $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function addSeller(StoreAddSellerRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $seller = $shop->users()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'profession' => $validated['profession'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'description' => $validated['description'],
            'shop_id' => $validated['shop'],
            'creator_id' => $authUser->id,
        ]);

        $seller->syncRoles([UserRoleEnum::Seller->value]);

        LogEvent::dispatchCreate($seller, $request, __('general.user.seller_created', ['name' => $seller->full_name]));

        return redirect(route('admin.shops.show.users', [$shop]));
    }

    /**
     * Show the form for adding a state.
     *
     * @param Shop $shop
     * @return View
     */
    public function showAddShopForm(Shop $shop): View
    {
        $shop->load('logo');

        return view('backoffice.admin.shops.add-shop', compact('shop'));
    }

    /**
     * Add a state.
     *
     * @param StoreAddShopRequest $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function addShop(StoreAddShopRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $shop = $shop->shops()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        LogEvent::dispatchCreate($shop, $request, __('general.shop.created', ['name' => $shop->name]));

        return redirect(route('admin.shops.show', [$shop]));
    }

    /**
     * Show the form for adding a vendor.
     *
     * @param Shop $shop
     * @return View
     */
    public function showAddVendorForm(Shop $shop): View
    {
        $shop->load('logo');

        return view('backoffice.admin.shops.add-vendor', compact('shop'));
    }

    /**
     * Add a vendor.
     *
     * @param StoreAddVendorRequest $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function addVendor(StoreAddVendorRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $vendor = $shop->vendors()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        LogEvent::dispatchCreate($vendor, $request, __('general.vendor.created', ['name' => $vendor->name]));

        return redirect(route('admin.shops.show.vendors', [$shop]));
    }

    /**
     * Show the form for adding a coupon.
     *
     * @param Shop $shop
     * @return View
     */
    public function showAddCouponForm(Shop $shop): View
    {
        $shop->load('logo');

        return view('backoffice.admin.shops.add-coupon', compact('shop'));
    }

    /**
     * Add a coupon.
     *
     * @param StoreAddCouponRequest $request
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function addCoupon(StoreAddCouponRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $coupon = $shop->coupons()->create([
            'code' => $validated['code'],
            'discount' => $validated['discount'],
            'promotion_started_at' => $validated['promotion_started_at'],
            'promotion_ended_at' => $validated['promotion_ended_at'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        LogEvent::dispatchCreate($coupon, $request, __('general.coupon.created', ['code' => $coupon->code]));

        return redirect(route('admin.shops.show.coupons', [$shop]));
    }
}
