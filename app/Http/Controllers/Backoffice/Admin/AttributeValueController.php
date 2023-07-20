<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Requests\AttributeValue\UpdateAttributeValueRequest;
use App\Http\Requests\AttributeValue\StoreAttributeValueRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Enums\GeneralStatusEnum;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use App\Events\LogEvent;

class AttributeValueController extends Controller
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

        $query = AttributeValue::with(['attribute', 'creator'])->allowed();

        $attributeValues = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.attribute-values.index', compact(['attributeValues', 'q']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backoffice.admin.attribute-values.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAttributeValueRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAttributeValueRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $status = $authUser->is_admin ? GeneralStatusEnum::Enable : GeneralStatusEnum::StandBy;

        $attributeValue = $authUser->createdAttributeValues()->create([
            'status' => $status,
            'name' => $validated['name'],
            'value' => $validated['value'],
            'description' => $validated['description'],
            'attribute_id' => $validated['attribute'],
        ]);

        LogEvent::dispatchCreate($attributeValue, $request, __('general.attribute-value.created', ['name' => $attributeValue->name]));

        return redirect(route('admin.attribute-values.show', [$attributeValue]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param AttributeValue $attributeValue
     * @return View
     */
    public function show(Request $request, AttributeValue $attributeValue): View
    {
        $q = $request->query('q');

        $attributeValue->load(['attribute', 'creator'])->loadCount('attributedProducts');

        $query = $attributeValue->attributedProducts()->allowed();

        $products = ($q)
            ? $query->search($q)->orderBy('name')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.attribute-values.show', compact(['attributeValue', 'products', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param AttributeValue $attributeValue
     * @return View
     */
    public function showLogs(AttributeValue $attributeValue): View
    {
        $attributeValue->load(['attribute', 'creator'])->loadCount('attributedProducts');

        $logs = $attributeValue->logs()->allowed()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.attribute-values.show-logs', compact(['attributeValue', 'logs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AttributeValue $attributeValue
     * @return View
     */
    public function edit(AttributeValue $attributeValue): View
    {
        $attributeValue->load('attribute');

        return view('backoffice.admin.attribute-values.edit', compact('attributeValue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAttributeValueRequest $request
     * @param AttributeValue $attributeValue
     * @return RedirectResponse
     */
    public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue): RedirectResponse
    {
        $validated = $request->validated();

        $attributeValue->update([
            'name' => $validated['name'],
            'value' => $validated['value'],
            'description' => $validated['description'],
            'attribute_id' => $validated['attribute'],
        ]);

        LogEvent::dispatchUpdate($attributeValue, $request, __('general.attribute-value.updated', ['name' => $attributeValue->name]));

        return redirect(route('admin.attribute-values.show', [$attributeValue]));
    }

    /**
     * Toggle attribute value status.
     *
     * @param Request $request
     * @param AttributeValue $attributeValue
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, AttributeValue $attributeValue): RedirectResponse
    {
        $message = $attributeValue->status_toggle['message'];
        $attributeValue->update(['status' => $attributeValue->status_toggle['next']]);

        LogEvent::dispatchUpdate($attributeValue, $request, $message);

        return back();
    }
}
