<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Organisation\StoreOrganisationRequest;
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
use App\Models\User;

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

        $organisations = ($q)
            ? Organisation::search($q)->orderBy('name')->paginate()
            : Organisation::orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.index', compact('organisations', 'q'));
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

        $organisation = Organisation::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'phone' => $validated['phone'],
            'description' => $validated['description']
        ]);

        LogEvent::dispatch($organisation, LogActionEnum::Create, "User $organisation->name created");

        return redirect(route('admin.organisations.show', [$organisation]));
    }

    /**
     * Display the specified resource.
     *
     * @param Organisation $organisation
     * @return View
     */
    public function show(Organisation $organisation): View
    {
//        $organisation = $organisation->load(['shops', 'vendors', 'merchant', 'creator', 'banner', 'logo', 'users']);
        $organisation = $organisation->load(['shops']);

        return view('backoffice.admin.organisations.create.show', compact('organisation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View|RedirectResponse
     */
    public function edit(User $user): View|RedirectResponse
    {
        if(!$this->authorized($user)) return back();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        if(!$this->authorized($user)) return back();

        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'username' => Str::slug($validated['name']),
            'profession' => $validated['profession'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
        ]);

        $user->syncRoles([Role::findOrCreate($validated['role'], 'web')]);

        LogEvent::dispatch($user, LogActionEnum::Update, "User $user->name updated");

        return redirect(route('users.show', [$user]));
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
