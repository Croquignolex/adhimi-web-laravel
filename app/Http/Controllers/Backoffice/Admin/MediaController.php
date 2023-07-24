<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Enums\MediaTypeEnum;
use App\Models\Coupon;
use App\Models\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('backoffice.admin.medias.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param MediaTypeEnum $mediaTypeEnum
     * @return View
     */
    public function indexMediaType(MediaTypeEnum $mediaTypeEnum): View
    {
        $medias = Media::with('creator')->allowed()->where('type', $mediaTypeEnum)->orderBy('created_at', 'desc')->paginate(9);

        return view('backoffice.admin.medias.index-type', compact(['medias', 'mediaTypeEnum']));
    }

    /**
     * Display the specified resource.
     *
     * @param Media $media
     * @return View
     */
    public function show(Media $media): View
    {
        return view('backoffice.admin.medias.show', compact('media'));
    }



    /**
     * Display the specified resource.
     *
     * @param Coupon $coupon
     * @return View
     */
    public function destroy(Coupon $coupon): View
    {
        $coupon->load('creator');

        return view('backoffice.admin.coupons.show', compact('coupon'));
    }
}
