<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Shop\StoreAddManagerRequest;
use App\Http\Requests\Shop\StoreAddSellerRequest;
use App\Http\Requests\Shop\UpdateShopRequest;
use App\Http\Requests\Shop\StoreShopRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
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

        $query = Shop::with(['organisation', 'manager', 'creator'])->allowed();

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

        $shop->load(['organisation', 'defaultAddress.state.country', 'manager', 'creator'])->loadCount('users');

        $query = $shop->users()->allowed();

        $users = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.show', compact(['shop', 'users', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Shop $shop
     * @return View
     */
    public function showLogs(Shop $shop): View
    {
        $shop->load(['organisation', 'defaultAddress.state.country', 'manager', 'creator'])->loadCount('users');

        $logs = $shop->logs()->allowed()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.shops.show-logs', compact(['shop', 'logs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Shop $shop
     * @return View|RedirectResponse
     */
    public function edit(Shop $shop): View|RedirectResponse
    {
        $shop->load('organisation');

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
            'description' => $validated['description'],
            'organisation_id' => $validated['organisation'],
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
     * Show update address form
     *
     * @param Shop $shop
     * @return View
     */
    public function showAddressForm(Shop $shop): View
    {
        $shop->load('defaultAddress.state.country');

        return view('backoffice.admin.shops.address', compact('shop'));
    }

    /**
     * Update profile default address
     *
     * @param Shop $shop
     * @param UpdateAddressRequest $request
     * @return RedirectResponse
     */
    public function defaultAddressUpdate(UpdateAddressRequest $request, Shop $shop): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $address = $shop->defaultAddress;

        if($address)
        {
            $address->update([
                'street_address' => $validated['street_address'],
                'street_address_plus' => $validated['street_address_plus'],
                'zipcode' => $validated['zipcode'],
                'phone_number_one' => $validated['phone_number_one'],
                'phone_number_two' => $validated['phone_number_two'],
                'description' => $validated['description'],
                'state_id' => $validated['state'],
            ]);

            LogEvent::dispatchUpdate($shop, $request, __('general.shop.shop_default_address_updated'));
        }
        else
        {
            $shop->defaultAddress()->create([
                'street_address' => $validated['street_address'],
                'street_address_plus' => $validated['street_address_plus'],
                'zipcode' => $validated['zipcode'],
                'phone_number_one' => $validated['phone_number_one'],
                'phone_number_two' => $validated['phone_number_two'],
                'description' => $validated['description'],
                'state_id' => $validated['state'],
                'creator_id' => $authUser->id,
            ]);

            LogEvent::dispatchCreate($shop, $request, __('general.shop.shop_default_address_created'));
        }

        return redirect(route('admin.shops.show', [$shop]));
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
        if(!$shop->can_add_manager) {
            ToastEvent::dispatchWarning(__('general.permission_denied'));
            return back();
        }

        $validated = $request->validated();

        $authUser = Auth::user();

        $manager = $shop->users()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'organisation_id' => $shop->organisation->id,
            'creator_id' => $authUser->id,
        ]);

        $manager->syncRoles([UserRoleEnum::ShopManager->value]);

        LogEvent::dispatchCreate($manager, $request, __('general.user.manager_created', ['name' => $manager->name]));

        return redirect(route('admin.shops.show', [$shop]));
    }

    /**
     * Show the form for adding a seller.
     *
     * @param Shop $shop
     * @return View|RedirectResponse
     */
    public function showAddSellerForm(Shop $shop): View|RedirectResponse
    {
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
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'organisation_id' => $shop->organisation->id,
            'creator_id' => $authUser->id,
        ]);

        $seller->syncRoles([UserRoleEnum::Seller->value]);

        LogEvent::dispatchCreate($seller, $request, __('general.user.seller_created', ['name' => $seller->name]));

        return redirect(route('admin.shops.show', [$shop]));
    }
}
