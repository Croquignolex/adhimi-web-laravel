<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\Attribute\UpdateAttributeRequest;
use App\Http\Requests\Attribute\StoreAttributeRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use App\Enums\GeneralStatusEnum;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Events\LogEvent;

class AttributeController extends Controller
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

        $query = Attribute::with('creator')->allowed();

        $attrs = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.attributes.index', compact(['attrs', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAttributeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAttributeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $attribute = $authUser->createdAttributes()->create([
            'status' => $status,
            'name' => $validated['name'], 
            'description' => $validated['description'],
        ]);

        LogEvent::dispatchCreate($attribute, $request, __('general.attribute.created', ['name' => $attribute->name]));

        return redirect(route('admin.attributes.show', [$attribute]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Attribute $attribute
     * @return View
     */
    public function show(Request $request, Attribute $attribute): View
    {
        $q = $request->query('q');

        $attribute->load('creator')->loadCount(['attributedProducts', 'attributeValues']);

        $query = $attribute->attributeValues()->allowed();

        $attributeValues = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.attributes.show', compact(['attribute', 'attributeValues', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Attribute $attribute
     * @return View
     */
    public function showProducts(Request $request, Attribute $attribute): View
    {
        $q = $request->query('q');

        $attribute->load('creator.avatar')->loadCount(['attributedProducts', 'attributesValues']);

        $query = $attribute->attributedProducts()->allowed();

        $products = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.organisations.show-products', compact(['attribute', 'products', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Attribute $attribute
     * @return View
     */
    public function showLogs(Attribute $attribute): View
    {
        $attribute->load('creator')->loadCount(['attributedProducts', 'attributesValues']);

        $logs = $attribute->logs()->allowed()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.attributes.show-logs', compact(['attribute', 'logs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Attribute $attribute
     * @return View
     */
    public function edit(Attribute $attribute): View
    {
        return view('backoffice.admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAttributeRequest $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute): RedirectResponse
    {
        $validated = $request->validated();

        $attribute->update([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        LogEvent::dispatchUpdate($attribute, $request, __('general.attribute.updated', ['name' => $attribute->name]));

        return redirect(route('admin.attributes.show', [$attribute]));
    }

    /**
     * Toggle attribute status.
     *
     * @param Request $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Attribute $attribute): RedirectResponse
    {
        $message = $attribute->status_toggle['message'];
        $attribute->update(['status' => $attribute->status_toggle['next']]);

        LogEvent::dispatchUpdate($attribute, $request, $message);

        return back();
    }
}
