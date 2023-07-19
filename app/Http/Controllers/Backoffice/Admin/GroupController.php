<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Group\StoreAddCategoryRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\UpdateBannerRequest;
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
use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('allow:super,admin')->only([
            'edit', 'update', 'statusToggle', 'changeBanner', 'removeBanner'
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

        $query = Group::with('creator')->allowed();

        $groups = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.groups.index', compact(['groups', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGroupRequest $request
     * @return RedirectResponse
     */
    public function store(StoreGroupRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $group = $authUser->createdGroups()->create([
            'status' => $status,
            'name' => $validated['name'], 
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
        ]);

        LogEvent::dispatchCreate($group, $request, __('general.group.created', ['name' => $group->name]));

        return redirect(route('admin.groups.show', [$group]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Group $group
     * @return View
     */
    public function show(Request $request, Group $group): View
    {
        $q = $request->query('q');

        $group->load('creator')->loadCount(['categories', 'products']);

        $query = $group->categories()->allowed();

        $categories = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.groups.show', compact(['group', 'categories', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Group $group
     * @return View
     */
    public function showProducts(Request $request, Group $group): View
    {
        $q = $request->query('q');

        $group->load('creator')->loadCount(['categories', 'products']);

        $query = $group->products()->allowed();

        $products = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.groups.show-products', compact(['group', 'products', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Group $group
     * @return View
     */
    public function showLogs(Group $group): View
    {
        $group->load('creator')->loadCount(['categories', 'products']);

        $logs = $group->logs()->allowed()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.groups.show-logs', compact(['group', 'logs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Group $group
     * @return View
     */
    public function edit(Group $group): View
    {
        return view('backoffice.admin.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGroupRequest $request
     * @param Group $group
     * @return RedirectResponse
     */
    public function update(UpdateGroupRequest $request, Group $group): RedirectResponse
    {
        $validated = $request->validated();

        $group->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
        ]);

        LogEvent::dispatchUpdate($group, $request, __('general.group.updated', ['name' => $group->name]));

        return redirect(route('admin.groups.show', [$group]));
    }

    /**
     * Toggle group status.
     *
     * @param Request $request
     * @param Group $group
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Group $group): RedirectResponse
    {
        $message = $group->status_toggle['message'];
        $group->update(['status' => $group->status_toggle['next']]);

        LogEvent::dispatchUpdate($group, $request, $message);

        return back();
    }

    /**
     * Update group banner.
     *
     * @param UpdateBannerRequest $request $
     * @param Group $group
     * @return RedirectResponse
     */
    public function changeBanner(UpdateBannerRequest $request, Group $group): RedirectResponse
    {
        $validated = $request->validated();

        $banner = $group->banner;

        $bannerName = Storage::disk('public')->put(MediaTypeEnum::Banner->value, $validated['banner']);

        if($bannerName)
        {
            if($banner)
            {
                $banner->update(['name' => $bannerName]);

                LogEvent::dispatchUpdate($group, $request, __('general.group.banner_updated', ['name' => $group->name]));
            }
            else
            {
                $group->banner()->create([
                    'name' => $bannerName,
                    'type' => MediaTypeEnum::Banner,
                    'creator_id' => Auth::id(),
                ]);

                LogEvent::dispatchCreate($group, $request, __('general.group.banner_created', ['name' => $group->name]));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete group banner.
     *
     * @param Request $request
     * @param Group $group
     * @return RedirectResponse
     */
    public function removeBanner(Request $request, Group $group): RedirectResponse
    {
        $group->banner()->delete();

        LogEvent::dispatchDelete($group, $request, __('general.group.banner_deleted', ['name' => $group->name]));

        return back();
    }

    /**
     * Show the form for adding a category.
     *
     * @param Group $group
     * @return View
     */
    public function showAddCategoryForm(Group $group): View
    {
        return view('backoffice.admin.groups.add-category', compact('group'));
    }

    /**
     * Add a coupon.
     *
     * @param StoreAddCategoryRequest $request
     * @param Group $group
     * @return RedirectResponse
     */
    public function addCategory(StoreAddCategoryRequest $request, Group $group): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $category = $group->categories()->create([
            'status' => $status,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
            'creator_id' => $authUser->id,
        ]);

        LogEvent::dispatchCreate($category, $request, __('general.category.created', ['code' => $category->name]));

        return redirect(route('admin.groups.show', [$group]));
    }
}
