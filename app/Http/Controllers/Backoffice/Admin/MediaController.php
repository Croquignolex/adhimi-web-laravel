<?php

namespace App\Http\Controllers\Backoffice\Admin;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Enums\MediaTypeEnum;
use App\Events\LogEvent;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * @param Request $request
     * @param Media $media
     * @return RedirectResponse
     */
    public function destroy(Request $request, Media $media): RedirectResponse
    {
        $entity = $media->mediatable;

        $media->delete();

        LogEvent::dispatchDelete($entity, $request, __('general.media.deleted'));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function clearGarbage(Request $request): RedirectResponse
    {
        $dbMedias = Media::withTrashed()->get();

        foreach (MediaTypeEnum::values() as $media)
        {
            $files = Storage::disk('public')->files($media);

            foreach ($files as $file)
            {
                $flag = true;
                if($dbMedias->contains(fn (Media $media) => $media->name === $file)) $flag = false;

                if($flag) Storage::disk('public')->delete($file);
            }
        }

        LogEvent::dispatchOther(Auth::user(), $request, __('general.media.garbage_cleared'));

        return back();
    }
}
