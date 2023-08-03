<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\User\StoreMerchantRequest;
use App\Http\Requests\User\StoreManagerRequest;
use App\Http\Requests\User\StoreSellerRequest;
use App\Http\Requests\User\StoreAdminRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Enums\UserRoleEnum;
use App\Events\ToastEvent;
use App\Events\LogEvent;
use App\Models\Shop;
use App\Models\User;

class UserController extends Controller
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

        $query = User::with(['shop', 'organisation', 'creator'])->allowed();

        $users = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.users.index', compact(['users', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function createAdmin(): View
    {
        return view('backoffice.admin.users.create-admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdminRequest $request
     * @return RedirectResponse
     */
    public function storeAdmin(StoreAdminRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $admin = $authUser->createdUsers()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
        ]);

        $admin->syncRoles([UserRoleEnum::Admin->value]);

        LogEvent::dispatchCreate($admin, $request, __('general.user.admin_created', ['name' => $admin->name]));

        return redirect(route('admin.users.show', [$admin]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function createMerchant(): View
    {
        return view('backoffice.admin.users.create-merchant');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMerchantRequest $request
     * @return RedirectResponse
     */
    public function storeMerchant(StoreMerchantRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $organisation = Organisation::find($validated['organisation']);

        if(!$organisation->can_add_merchant) {
            ToastEvent::dispatchWarning(__('general.permission_denied'));
            return back();
        }

        $authUser = Auth::user();

        $merchant = $organisation->users()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        $merchant->syncRoles([UserRoleEnum::Merchant->value]);

        LogEvent::dispatchCreate($merchant, $request, __('general.user.merchant_created', ['name' => $merchant->name]));

        return redirect(route('admin.users.show', [$merchant]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function createManager(): View
    {
        return view('backoffice.admin.users.create-manager');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreManagerRequest $request
     * @return RedirectResponse
     */
    public function storeManager(StoreManagerRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $organisation = Organisation::find($validated['organisation']);
        $shop = Shop::find($validated['shop']);

        if(!$organisation->can_add_manager || !$shop->can_add_manager) {
            ToastEvent::dispatchWarning(__('general.permission_denied'));
            return back();
        }

        $authUser = Auth::user();

        $manager = $organisation->users()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'shop_id' => $validated['shop'],
            'creator_id' => $authUser->id,
        ]);

        $manager->syncRoles([UserRoleEnum::ShopManager->value]);

        LogEvent::dispatchCreate($manager, $request, __('general.user.manager_created', ['name' => $manager->name]));

        return redirect(route('admin.users.show', [$manager]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function createSeller(): View
    {
        return view('backoffice.admin.users.create-seller');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSellerRequest $request
     * @return RedirectResponse
     */
    public function storeSeller(StoreSellerRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $seller = $authUser->createdUsers()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'shop_id' => $validated['shop'],
            'organisation_id' => $validated['organisation'],
            'creator_id' => $authUser->id,
        ]);

        $seller->syncRoles([UserRoleEnum::Seller->value]);

        LogEvent::dispatchCreate($seller, $request, __('general.user.manager_created', ['name' => $seller->name]));

        return redirect(route('admin.users.show', [$seller]));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        $user->load(['shop', 'organisation', 'creator']);

        return view('backoffice.admin.users.show', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function showLogs(User $user): View
    {
        $user->load(['shop', 'organisation', 'creator']);

        $logs = $user->logs()->allowed()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.users.show-logs', compact(['user', 'logs']));
    }

    /**
     * Toggle user status.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, User $user): RedirectResponse
    {
        $message = $user->status_toggle['message'];
        $user->update(['status' => $user->status_toggle['next']]);

        LogEvent::dispatchUpdate($user, $request, $message);

        return back();
    }
}
