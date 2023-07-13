<?php

namespace App\Http\Controllers\Backoffice\Admin;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Events\LogEvent;
use App\Models\Customer;

class CustomerController extends Controller
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

        $query = Customer::with('avatar');

        $customers = ($q)
            ? $query->search($q)->orderBy('first_name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.customers.index', compact(['customers', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return View
     */
    public function show(Customer $customer): View
    {
        $customer->load(['avatar', 'defaultAddress.state.country', 'billingAddress.state.country', 'shippingAddress.state.country'])
            ->loadCount('ratings');

        return view('backoffice.admin.customers.show', compact('customer'));
    }

    /**
     * Toggle customer status.
     *
     * @param Request $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Customer $customer): RedirectResponse
    {
        $message = $customer->status_toggle['message'];
        $customer->update(['status' => $customer->status_toggle['next']]);

        LogEvent::dispatchUpdate($customer, $request, $message);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return View
     */
    public function showLogs(Customer $customer): View
    {
        $customer->load(['avatar', 'defaultAddress.state.country', 'billingAddress.state.country', 'shippingAddress.state.country', 'logs.creator.avatar'])
            ->loadCount('ratings');

        $logs = $customer->logs()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.customers.show-logs', compact(['customer', 'logs']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Customer $customer
     * @return View
     */
    public function showRatings(Request $request, Customer $customer): View
    {
        $q = $request->query('q');

        $customer->load(['avatar', 'defaultAddress.state.country', 'billingAddress.state.country', 'shippingAddress.state.country', 'ratings'])
            ->loadCount('ratings');

        $query = $customer->ratings();

        $ratings = ($q)
            ? $query->search($q)->orderBy('note')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.customers.show-ratings', compact(['customer', 'ratings', 'q']));
    }
}
