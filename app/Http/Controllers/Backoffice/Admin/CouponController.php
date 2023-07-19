<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Http\Requests\Coupon\StoreCouponRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Events\LogEvent;
use App\Models\Coupon;

class CouponController extends Controller
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

        $query = Coupon::with('creator')->allowed();

        $coupons = ($q)
            ? $query->search($q)->orderBy('code')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.coupons.index', compact(['coupons', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCouponRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $coupon = $authUser->createdCoupons()->create([
            'code' => $validated['code'],
            'discount' => $validated['discount'],
            'promotion_started_at' => $validated['promotion_started_at'],
            'promotion_ended_at' => $validated['promotion_ended_at'],
            'description' => $validated['description'],
        ]);

        LogEvent::dispatchCreate($coupon, $request, __('general.coupon.created', ['code' => $coupon->code]));

        return redirect(route('admin.coupons.show', [$coupon]));
    }

    /**
     * Display the specified resource.
     *
     * @param Coupon $coupon
     * @return View
     */
    public function show(Coupon $coupon): View
    {
        $coupon->load('creator');

        return view('backoffice.admin.coupons.show', compact('coupon'));
    }

    /**
     * Display the specified resource.
     *
     * @param Coupon $coupon
     * @return View
     */
    public function showLogs(Coupon $coupon): View
    {
        $coupon->load('creator');

        $logs = $coupon->logs()->allowed()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.coupons.show-logs', compact(['coupon', 'logs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Coupon $coupon
     * @return View
     */
    public function edit(Coupon $coupon): View
    {
        return view('backoffice.admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCouponRequest $request
     * @param Coupon $coupon
     * @return RedirectResponse
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $validated = $request->validated();

        $coupon->update([
            'code' => $validated['code'],
            'discount' => $validated['discount'],
            'promotion_started_at' => $validated['promotion_started_at'],
            'promotion_ended_at' => $validated['promotion_ended_at'],
            'description' => $validated['description'],
        ]);

        LogEvent::dispatchUpdate($coupon, $request, __('general.coupon.updated', ['code' => $coupon->code]));

        return redirect(route('admin.coupons.show', [$coupon]));
    }

    /**
     * Toggle coupon status.
     *
     * @param Request $request
     * @param Coupon $coupon
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Coupon $coupon): RedirectResponse
    {
        $message = $coupon->status_toggle['message'];
        $coupon->update(['status' => $coupon->status_toggle['next']]);

        LogEvent::dispatchUpdate($coupon, $request, $message);

        return back();
    }
}
