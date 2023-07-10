<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Vendor\UpdateVendorRequest;
use App\Http\Requests\Vendor\StoreVendorRequest;
use App\Http\Requests\UpdateAddressRequest;
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
use App\Models\Vendor;

class VendorController extends Controller
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

        $query = Vendor::with(['logo', 'organisation.logo', 'creator.avatar']);

        $vendors = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.vendors.index', compact(['vendors', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVendorRequest $request
     * @return RedirectResponse
     */
    public function store(StoreVendorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $vendor = $authUser->createdVendors()->create([
            'status' => $status,
            'name' => $validated['name'], 
            'description' => $validated['description'],
            'organisation_id' => $validated['organisation'],
        ]);

        LogEvent::dispatchCreate($vendor, $request, __('general.vendor.created', ['name' => $vendor->name]));

        return redirect(route('admin.vendors.show', [$vendor]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Vendor $vendor
     * @return View
     */
    public function show(Request $request, Vendor $vendor): View
    {
        $q = $request->query('q');

//        $vendor->load(['logo', 'organisation.logo', 'creator.avatar', 'products.creator.avatar'])
//            ->loadCount('products');

        $vendor->load(['logo', 'organisation.logo', 'creator.avatar']);

//        $query = $vendor->products();
//
//        $products = ($q)
//            ? $query->search($q)->orderBy('name')->get()
//            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.vendors.show', compact(['vendor', 'q']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Vendor $vendor
     * @return View
     */
    public function edit(Vendor $vendor): View
    {
        $vendor->load('logo');

        return view('backoffice.admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVendorRequest $request
     * @param Vendor $vendor
     * @return RedirectResponse
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validated();

        $vendor->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'organisation_id' => $validated['organisation'],
        ]);

        LogEvent::dispatchUpdate($vendor, $request, __('general.vendor.updated', ['name' => $vendor->name]));

        return redirect(route('admin.vendors.show', [$vendor]));
    }

    /**
     * Toggle vendor status.
     *
     * @param Request $request
     * @param Vendor $vendor
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Vendor $vendor): RedirectResponse
    {
        $message = $vendor->status_toggle['message'];
        $vendor->update(['status' => $vendor->status_toggle['next']]);

        LogEvent::dispatchUpdate($vendor, $request, $message);

        return back();
    }

    /**
     * Show update address form
     *
     * @param Vendor $vendor
     * @return View
     */
    public function showAddressForm(Vendor $vendor): View
    {
        $vendor->load('defaultAddress.state.country');

        return view('backoffice.admin.vendors.address', compact('vendor'));
    }

    /**
     * Update profile default address
     *
     * @param Vendor $vendor
     * @param UpdateAddressRequest $request
     * @return RedirectResponse
     */
    public function defaultAddressUpdate(UpdateAddressRequest $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $address = $vendor->defaultAddress;

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

            LogEvent::dispatchUpdate($vendor, $request, __('general.vendor.vendor_default_address_updated'));
        }
        else
        {
            $vendor->defaultAddress()->create([
                'street_address' => $validated['street_address'],
                'street_address_plus' => $validated['street_address_plus'],
                'zipcode' => $validated['zipcode'],
                'phone_number_one' => $validated['phone_number_one'],
                'phone_number_two' => $validated['phone_number_two'],
                'description' => $validated['description'],
                'state_id' => $validated['state'],
                'creator_id' => $authUser->id,
            ]);

            LogEvent::dispatchCreate($vendor, $request, __('general.vendor.vendor_default_address_created'));
        }

        return redirect(route('admin.vendors.show', [$vendor]));
    }

    /**
     * Update vendor logo.
     *
     * @param UpdateLogoRequest $request $
     * @param Vendor $vendor
     * @return RedirectResponse
     */
    public function changeLogo(UpdateLogoRequest $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validated();

        $logo = $vendor->logo;

        $logoName = Storage::disk('public')->put(MediaTypeEnum::Logo->value, $validated['logo']);

        if($logoName)
        {
            if($logo)
            {
                $logo->update(['name' => $logoName]);

                LogEvent::dispatchUpdate($vendor, $request, __('general.vendor.logo_updated', ['name' => $vendor->name]));
            }
            else
            {
                $vendor->logo()->create([
                    'name' => $logoName,
                    'type' => MediaTypeEnum::Logo,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($vendor, $request, __('general.vendor.logo_created', ['name' => $vendor->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete vendor logo.
     *
     * @param Request $request
     * @param Vendor $vendor
     * @return RedirectResponse
     */
    public function removeLogo(Request $request, Vendor $vendor): RedirectResponse
    {
        $vendor->logo()->delete();

        LogEvent::dispatchDelete($vendor, $request, __('general.vendor.logo_deleted', ['name' => $vendor->name]));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Vendor $vendor
     * @return View
     */
    public function showLogs(Vendor $vendor): View
    {
//        $vendor->load(['logo', 'organisation.logo', 'creator.avatar', 'logs.creator.avatar'])
//            ->loadCount('products');

        $vendor->load(['logo', 'organisation.logo', 'creator.avatar', 'logs.creator.avatar']);

        $logs = $vendor->logs()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.vendors.show-logs', compact(['vendor', 'logs']));
    }
}
