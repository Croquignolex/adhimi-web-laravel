<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\State\UpdateStateRequest;
use App\Http\Requests\State\StoreStateRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use App\Enums\GeneralStatusEnum;
use Illuminate\Http\Request;
use App\Events\LogEvent;
use App\Models\State;

class StateController extends Controller
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

        $query = State::with(['country', 'creator'])->allowed();

        $states = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.states.index', compact(['states', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.states.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStateRequest $request
     * @return RedirectResponse
     */
    public function store(StoreStateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $state = $authUser->createdStates()->create([
            'status' => $status,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'country_id' => $validated['country'],
        ]);

        LogEvent::dispatchCreate($state, $request, __('general.state.created', ['name' => $state->name]));

        return redirect(route('admin.states.show', [$state]));
    }

    /**
     * Display the specified resource.
     *
     * @param State $state
     * @return View
     */
    public function show(State $state): View
    {
        $state->load(['country', 'creator']);

        return view('backoffice.admin.states.show', compact(['state']));
    }

    /**
     * Display the specified resource.
     *
     * @param State $state
     * @return View
     */
    public function showLogs(State $state): View
    {
        $state->load(['country', 'creator']);

        $logs = $state->logs()->allowed()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.states.show-logs', compact(['state', 'logs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param State $state
     * @return View
     */
    public function edit(State $state): View
    {
        $state->load('country');

        return view('backoffice.admin.states.edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStateRequest $request
     * @param State $state
     * @return RedirectResponse
     */
    public function update(UpdateStateRequest $request, State $state): RedirectResponse
    {
        $validated = $request->validated();

        $state->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'country_id' => $validated['country'],
        ]);

        LogEvent::dispatchUpdate($state, $request, __('general.state.updated', ['name' => $state->name]));

        return redirect(route('admin.states.show', [$state]));
    }

    /**
     * Toggle state status.
     *
     * @param Request $request
     * @param State $state
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, State $state): RedirectResponse
    {
        $message = $state->status_toggle['message'];
        $state->update(['status' => $state->status_toggle['next']]);

        LogEvent::dispatchUpdate($state, $request, $message);

        return back();
    }
}
