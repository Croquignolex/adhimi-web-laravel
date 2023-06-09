<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;
use App\Enums\UserStatusEnum;
use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use Illuminate\Support\Str;
use App\Events\ToastEvent;
use App\Events\LogEvent;
use App\Models\Country;
use App\Models\User;

class CountryController extends Controller
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

        $query = Country::withCount('states');

        $countries = ($q)
            ? $query->search($q)->orderBy('name')->paginate()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.countries.index', compact('countries', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCountryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCountryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $country = Country::create([
            'name' => $validated['name'],
            'phone_code' => $validated['phone_code'],
            'description' => $validated['description']
        ]);

        LogEvent::dispatch($country, LogActionEnum::Create, __('general.country.created', ['name' => $country->name]));

        return redirect(route('admin.countries.show', [$country]));
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @return View
     */
    public function show(Country $country): View
    {
        $country->load(['states']);

        return view('backoffice.admin.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Country $country
     * @return View|RedirectResponse
     */
    public function edit(Country $country): View|RedirectResponse
    {
        return view('backoffice.admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCountryRequest $request
     * @param Country $country
     * @return RedirectResponse
     */
    public function update(UpdateCountryRequest $request, Country $country): RedirectResponse
    {
        $validated = $request->validated();

        $country->update([
            'name' => $validated['name'],
            'phone_code' => $validated['phone_code'],
            'description' => $validated['description'],
        ]);

        LogEvent::dispatch($country, LogActionEnum::Update, __('general.country.updated', ['name' => $country->name]));

        return redirect(route('admin.countries.show', [$country]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        if(!$this->authorized($user)) return back();

        $nextStatus = enums_equals($user->status, UserStatusEnum::Active)
            ? UserStatusEnum::Blocked
            : UserStatusEnum::Active;

        $user->update(['status' => $nextStatus]);

        $user->notify(new AccountDeactivatedNotification());

        LogEvent::dispatch($user, LogActionEnum::Custom, "User $user->name status toggled");

        return back();
    }

    /**
     * @param User $user
     * @return bool
     */
    private function authorized(User $user): bool
    {
        if(Auth::id() === $user->id)
        {
            ToastEvent::dispatch("You are not allow to perform this action", ToastTypeEnum::Warning);
            return false;
        }

        return true;
    }
}
