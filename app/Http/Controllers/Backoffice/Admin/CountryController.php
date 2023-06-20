<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Country\StoreAddStateRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateFlagRequest;
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
use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('allow:super,admin')->only([
            'edit', 'update', 'statusToggle', 'changeFlag', 'removeFlag'
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

        $query = Country::with('creator.avatar');

        $countries = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.countries.index', compact(['countries', 'q']));
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

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $country = $authUser->createdCountries()->create([
            'status' => $status,
            'name' => $validated['name'],
            'phone_code' => $validated['phone_code'],
            'description' => $validated['description'],
        ]);

        LogEvent::dispatchCreate($country, $request, __('general.country.created', ['name' => $country->name]));

        return redirect(route('admin.countries.show', [$country]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Country $country
     * @return View
     */
    public function show(Request $request, Country $country): View
    {
        $q = $request->query('q');

        $country->load(['creator.avatar', 'states', 'flag'])->loadCount('states');

        $query = $country->states()->with('creator.avatar');
        $creator = $country->creator;
        $flag = $country->flag;

        $states = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.countries.show', compact(['country', 'states', 'flag', 'creator', 'q']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Country $country
     * @return View|RedirectResponse
     */
    public function edit(Country $country): View|RedirectResponse
    {
        $country->load('flag');
        $flag = $country->flag;

        return view('backoffice.admin.countries.edit', compact(['country', 'flag']));
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

        LogEvent::dispatchUpdate($country, $request, __('general.country.updated', ['name' => $country->name]));

        return redirect(route('admin.countries.show', [$country]));
    }

    /**
     * Show the form for adding a state.
     *
     * @param Country $country
     * @return View|RedirectResponse
     */
    public function showAddStateForm(Country $country): View|RedirectResponse
    {
        $country->load('flag');
        $flag = $country->flag;

        return view('backoffice.admin.countries.add-state', compact(['country', 'flag']));
    }

    /**
     * Add a state.
     *
     * @param StoreAddStateRequest $request
     * @param Country $country
     * @return RedirectResponse
     */
    public function addState(StoreAddStateRequest $request, Country $country): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $state = $country->states()->create([
            'status' => $status,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'creator_id' => $authUser->id,
        ]);

        LogEvent::dispatchCreate($state, $request, __('general.state.created', ['name' => $state->name]));

        return redirect(route('admin.countries.show', [$country]));
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @return View
     */
    public function showLogs(Country $country): View
    {
        $country->load(['logs', 'flag'])->loadCount('states');

        $logs = $country->logs()->with('creator.avatar')->orderBy('created_at', 'desc')->paginate();
        $flag = $country->flag;

        return view('backoffice.admin.countries.show-logs', compact('country', 'logs', 'flag'));
    }

    /**
     * Toggle country status.
     *
     * @param Request $request
     * @param Country $country
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Country $country): RedirectResponse
    {
        $message = $country->status_toggle['message'];
        $country->update(['status' => $country->status_toggle['next']]);

        LogEvent::dispatchUpdate($country, $request, $message);

        return back();
    }

    /**
     * Update country flag.
     *
     * @param UpdateFlagRequest $request $
     * @param Country $country
     * @return RedirectResponse
     */
    public function changeFlag(UpdateFlagRequest $request, Country $country): RedirectResponse
    {
        $validated = $request->validated();

        $flag = $country->flag;

        $flagName = Storage::disk('public')->put(MediaTypeEnum::Flag->value, $validated['flag']);

        if($flagName)
        {
            if($flag)
            {
                $flag->update(['name' => $flagName]);

                LogEvent::dispatchUpdate($country, $request, __('general.country.flag_updated', ['name' => $country->name]));
            }
            else
            {
                $country->flag()->create([
                    'name' => $flagName,
                    'type' => MediaTypeEnum::Flag,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($country, $request, __('general.country.flag_created', ['name' => $country->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete country flag.
     *
     * @param Request $request
     * @param Country $country
     * @return RedirectResponse
     */
    public function removeFlag(Request $request, Country $country): RedirectResponse
    {
        $country->flag()->delete();

        LogEvent::dispatchDelete($country, $request, __('general.country.flag_deleted', ['name' => $country->name]));

        return back();
    }
}
