<?php

namespace App\Http\Controllers\Backoffice\Admin;

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
            ? Organisation::with('merchant')->search($q)->orderBy('name')->paginate()
            : Organisation::with('merchant')->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.index', compact('organisations', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'profession' => $validated['profession'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate']
        ]);

        LogEvent::dispatch($user, LogActionEnum::Create, "User $user->name created");

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
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
